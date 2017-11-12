<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnimalsController extends Controller
{
	#region MAIN METHODS
    public function create()
    {
	    return view('add-animal');
    }
    
    public function store(StoreAnimalPost $request)
    {
	    session()->flash('message','Your animal saved successfuly');
	    return back();
    }
    
    #endregion
		
	#region AJAX METHODS
	public function loadFormPart($type, $subtype=null)
	{
		$list = null;
		if($type == 'puppy'){
			$list = config('globals.puppyTypes');
			$fieldName = 'puppySubtype';
		}elseif ($type == 'kitten'){
			$fieldName = 'kittenSubtype';
			$list = config('globals.kittenFur');
		}
		if(count($list)>0){
			return view('form-partials.animal-subtype-select',
				[
					'list'=>$list,
					'type'=>$type,
					'subtype'=>$subtype,
					'fieldName'=>$fieldName,
				]
			);
		}else{ return null; }
	}
	#endregion
 
}
