<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class TestController extends Controller
{
    public function test(){

      $users = User::all();
      return view('test')->with('users', $users);
    }
}
