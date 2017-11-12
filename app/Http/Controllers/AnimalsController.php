<?php

namespace App\Http\Controllers;

use App\Animal;
use App\Http\Requests\StoreAnimalPost;
use App\Kitten;
use App\Puppy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnimalsController extends Controller
{
	#region CLASS PROPERTIES
		private $storeRequest;
	#endregion
	
	#region MAIN METHODS
    public function create()
    {
	    return view('add-animal');
    }
    
    public function store(StoreAnimalPost $request)
    {
    	$this->storeRequest = $request;

    	$animalType = $this->storeRequest->input('type');
    	
		$animalID = $this->saveAnimalToDB($animalType);
	 
		if($this->storeRequest->hasFile('photo')){
			$this->savePhotoToDisc($animalType, $animalID);
		}
	    
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
	
	#region SERVICE METHODS
	private function saveAnimalToDB($animalType)
	{
		$animalID = $this->saveToAnimalsTable($animalType);

		if($animalType == 'puppy'){
			$this->saveToPuppiesTable($animalID);
		}elseif($animalType == 'kitten'){
			$this->saveToKittensTable($animalID);
		}
		return $animalID;
	}
	
	private function saveToAnimalsTable($animalType)
	{
		$newAnimal = [
			'owner_id'=>Auth::id(),
			'type'=>$animalType,
			'name'=>$this->storeRequest->input('animal-name'),
			'photo'=>'undefined',
			'victories'=>0,
			'failures'=>0,
			'score'=>0
		];
		$newAnimal = Animal::create($newAnimal);
		return $newAnimal->id;
	}
	
	private function saveToKittensTable($animalID)
	{
		$newKitten = [
			'animal_id'=>$animalID,
			'fur'=>$this->storeRequest->input('subtype')
		];
		Kitten::create($newKitten);
	}
	
	private function saveToPuppiesTable($animalID)
	{
		$newPuppy = [
			'animal_id'=>$animalID,
			'type'=>$this->storeRequest->input('subtype')
		];
		Puppy::create($newPuppy);
	}
	
	private function savePhotoToDisc($animalType, $animalID)
	{
		$fileExtension = $this->storeRequest->photo->extension();
		$fileName = Auth::id()."-".$animalID.".".$fileExtension;
		$pathToFile = null;
		if($animalType == 'puppy'){
			$pathToFile = $this->storeRequest
				->photo
				->storeAs('public/puppies',$fileName);
		}elseif($animalType == 'kitten'){
			$pathToFile = $this->storeRequest
				->photo
				->storeAs('public/kittens',$fileName);
		}
		
		// updating photo column in animal table
		if($pathToFile !== null){
			$animal = Animal::find($animalID);
			$animal->photo = $pathToFile;
			$animal->save();
		}
	}
	#endregion
 
}
