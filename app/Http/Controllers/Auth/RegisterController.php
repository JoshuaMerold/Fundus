<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;

use App\User;
use App\Course;
use App\CourseRight;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [    // Anpassung für Anmeldeseite mit Registrierung & Anmeldung
            'register_name' => ['required', 'string', 'max:255'],
            'register_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'register_password' => ['required', 'string', 'min:8', 'confirmed'],
            'courseid' => ['required', 'string', 'max:255'],

        ]);
        $validator->setAttributeNames([
          'register_name' => 'username',
          'register_email' => 'email',
          'register_password' => 'password',
          'register_courseid' => 'courseid',
        ]);

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['register_name'],
            'email' => $data['register_email'],
            'password' => Hash::make($data['register_password']),
            'courseid' => $data['course'],
        ]);
    }

    public function registerNEW(Request $request){

      $user = new User;

      if(is_numeric(Str::substr($request->register_email, -2))){

        $courseShortcut = Course::all()->where('id', $request->course)->first()->shortcut;

        $validator = Courseright::all()->where('coursepartition', $courseShortcut.Str::substr($request->register_email, -2));

        if(count($validator) === 0){
          $newCourseRight = new Courseright;
          $newCourseRight->coursepartition = $courseShortcut.Str::substr($request->register_email, -2);
          $newCourseRight->representative1 = "none";
          $newCourseRight->representative2 = "none";
          $newCourseRight->save();
        }

        $user->username = $request->register_email;
        $user->password = Hash::make($request->register_password);
        $user->email = $request->register_email."@lehre.mosbach.dhbw.de";
        $user->courseid = $request->course;
        $user->coursename = $courseShortcut.Str::substr($request->register_email, -2);
        $user->rights = "basic";
        $user->save();
        return redirect('/login')->with('success', 'Erfolgreich registriert! Bitte melde dich an!');
      }
      else {
        return redirect('/login')->with('error', 'Es handelt sich bei der von Ihnen eingegebenen Kennung um keine E-Mail der DHBW Mosbach. Bsp.: test.test.20');
      }



    }

    public function showRegistrationForm(){
      return redirect('/login');
    }
}
