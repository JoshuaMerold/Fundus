<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\User;
use App\Course;
use App\Module;
use App\Lesson;
use App\File;

class FileController extends Controller
{
  public function download($id)
  {
      //gewünschte Datei wird mit id von DB abgefragt
      $fileToDownload = File::all()->where('id', $id)->first();

      //Name wird verlangt, damit gewollte Datei angesprochen werden kann
      $filename = $fileToDownload->name;

      // Gibt den Pfad der gewünschten Datei an
      $file_path = storage_path() . "/../public/files/" . $filename;

      //legt Grundregeln fest / bei mir sind alle Dateiformate erlaubt
      $headers = array(
        'Content-Type' => 'application/*',
        // 'Content-Disposition' => 'attachment; filename=' . $filename,
      );

      // Wenn Datei existiert wird Sie zurückgeliefert und heruntergeladen
      if ( file_exists( $file_path ) ) {
          return \Response::download( $file_path, $filename, $headers );
      } else {
          //Fehlermeldung wenn Datei nicht mehr auf dem Server ist. Wird in Files ausgegeben
          return redirect('/files')->with('error', 'Datei ist nicht mehr auf dem Server...');
      }

  }

  public function add($id){
    return view('forms.addFile');
  }

  public function store(Request $request, $id){

    $this->validate($request, [
          'fileToUpload' => 'required'
        ]);

    $user = Auth::user();
    $userid = $user->id;

    $courseid = $user->courseid;

      //$eingabe nimmt die hochgeladene Datei entgegnen
      $eingabe = $request->fileToUpload;

      //schreibt den Namen der Datei in $filename
      $filename = $eingabe->getClientOriginalName();

      //gibt den Pfad für Speicherung des Bildes an (nicht public)
      $file_path = storage_path() . "/../public/files/" .$filename;

      //Erstellt Datei in Datenbank
      //Object von File (Model) wird erstellt
      $file = new File;

      //Daten werden den Eigenschaften des Models zugewiesen
      $file->name = $eingabe->getClientOriginalName();
      $file->extension = $eingabe->getClientOriginalExtension();
      // $file->size = $eingabe->getClientSize()/1000;
      $file->path = "/files/".$filename;
      $file->type = $request->type;
      $file->lessonid = $id;
      $file->creatoruserid = $userid;
      $file->courseid = $courseid;
      $file->voting = 0;

      //mit save() werden die Einträge an die Datenbank übermittelt und gespeichert
      $file->save();

      //wurde der "submit" Button geklickt wird die Datei in das gewünschte Verzeichnes geladen

      move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_path);


      //Durch redirect wird man auf eine gewünschte Seite geleitet.
      // mit ->with() habe ich dem View gewünschte Mitteilungen(Hier eine success-Meldung wenn es geklappt hat) übergeben
      return redirect('/'.$id.'/'.$request->type)->with('success', 'Datei Hochgeladen!');

      //Seite wird geladen...
  }
}
