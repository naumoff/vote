<?php

namespace App\Http\Controllers;

use App\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    #region MAIN METHODS
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$animalsOfLoggedUser = $this
		    ->getAllAnimalsForLoggedUser()
		    ->toArray();
        return view('home', ['myAnimals'=>$animalsOfLoggedUser]);
    }
    #endregion
	
	#region SERVICE MATHODS
	private function getAllAnimalsForLoggedUser()
	{
		$userID = Auth::id();
		$data = Animal::getUserAnimals($userID,50);
		return $data;
	}
	#endregion
}
