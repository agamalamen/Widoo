<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Challenge;
use App\Http\Requests;

class HomeController extends Controller
{
    public function getWelcome()
    {
      $challenges = Challenge::all();
      return view('welcome')->with(['challenges' => $challenges]);
    }
}
