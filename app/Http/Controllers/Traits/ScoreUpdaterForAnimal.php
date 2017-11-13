<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 13.11.2017
 * Time: 12:00
 */

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\Animal;

trait ScoreUpdaterForAnimal {
	#region SERVICE METHODS
	private function updateHitsAndScoreInDB(Request $request)
	{
		$this->updateAnimalRow($request->input('id_0'),$request->input('hit_0'));
		$this->updateAnimalRow($request->input('id_1'),$request->input('hit_1'));
	}
	
	private function updateAnimalRow($animalId, $animalHit)
	{
		$animal = Animal::find($animalId);
		if($animalHit == -1){
			$animal->failures = $animal->failures+1;
			$animal->score = $animal->score-1;
		}elseif ($animalHit == 1){
			$animal->victories = $animal->victories+1;
			$animal->score = $animal->score+1;
		}
		$animal->save();
	}
	#endregion
}