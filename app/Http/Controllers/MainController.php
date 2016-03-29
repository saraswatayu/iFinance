<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

class MainController extends Controller
{
	public function home(){
		return view('home');
	}
	public function profile(){
		return view('profile');
	}
}