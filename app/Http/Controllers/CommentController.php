<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Comment;
use App\File;
use App\Course;
use App\Vote;

class CommentController extends NavbarController
{
    public function show($id){

      $rating = 0;

      $comments = Comment::all()->where('fileid', $id);
      $fileToShow = File::all()->where('id', $id)->first();
      $users = User::all();
      $courses = Course::all();
      $votes = Vote::all()->where('fileid', $id);

      foreach ($votes as $vote) {
        $rating = $rating + $vote->vote;
      }


      return view('forms.addComment')->with('comments', $comments)->with('fileToShow', $fileToShow)->with('users', $users)->with('courses', $courses)->with('rating', $rating);

    }

    public function store(Request $request, $id){


      $newComment = new Comment;
      $newComment->content = $request->content;
      $newComment->userid = Auth::user()->id;
      $newComment->fileid = $id;
      $newComment->save();
      return redirect('/'.$id.'/add/comment')->with('success', 'erfolgreich kommentiert');
    }
}
