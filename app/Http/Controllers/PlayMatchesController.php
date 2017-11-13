<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ScoreUpdaterForAnimal;
use App\Http\Requests\UpdateAnimalScorePost;
use App\Services\UserMatchServiceInterface;
use Illuminate\Http\Request;

class PlayMatchesController extends Controller
{
	use ScoreUpdaterForAnimal;
	
    #region CLASS PROPERTIES
	private $userMatchService;
	#endregion
	
	#region MAIN METHODS
	
	public function __construct(UserMatchServiceInterface $userMatchService)
	{
		$this->userMatchService = $userMatchService;
	}
	public function play()
	{
		$this->checkIfMatchesExistElseCreate();
		$match = $this->takeMatch();

		return view('play-match',['match'=>$match]);
	}
	
	public function vote(UpdateAnimalScorePost $request)
	{
		$this->updateHitsAndScoreInDB($request);
		return back();
	}
	#endregion
	
	#region SERVICE METHODS
	private function checkIfMatchesExistElseCreate()
	{
		$this->userMatchService->saveMatchesForUser();
	}
	
	private function takeMatch()
	{
		return $this->userMatchService->takeMatchForUser();
	}
	#endregion
}
