<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class MainController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
	public function home(){
		return view('home');
	}
    
	public function profile(){
		return view('profile');
	}
}