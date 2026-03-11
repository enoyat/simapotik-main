<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class Home extends Controller
{
    
	public function index() {
		return view('home');
	}

	public function agenda() {
		return view('agenda');
	}
	public function biaya() {
		return view('biaya');
	}
	public function panduanpmb() {
		return view('panduanpmb');
	}
	public function panduanbayar() {
		return view('panduanbayar');
	}
	public function logout() {
		Session::forget('kdregister');
		return view('home');
	}
}
