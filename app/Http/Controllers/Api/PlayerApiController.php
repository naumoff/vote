<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 12.11.2017
 * Time: 21:18
 */

namespace App\Http\Controllers\Api;

use App\Animal;
use App\Services\MatchTransformer;
use App\Services\UserMatchServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\ScoreUpdaterForAnimal;

class PlayerApiController extends ApiController
{
	use ScoreUpdaterForAnimal;
	
	#region CLASS PROPERTIES
	private $matchTransformer;
	private $userMatchService;
	#endregion
	
	public function __construct(MatchTransformer $matchTransformer,
	                            UserMatchServiceInterface $userMatchService)
	{
		$this->matchTransformer = $matchTransformer;
		$this->userMatchService = $userMatchService;
	}
	
	#region MAIN METHODS
	public function showMatch()
	{
		$this->userMatchService->saveMatchesForUser();
		$match = $this->userMatchService->takeMatchForUser();
		$match = $this->matchTransformer->transform($match);
		return $this->respond($match);
	}
	
	public function voteMatch(Request $request)
	{
		$validator = Validator::make( $request->all(), [
			'id_0' => 'required|numeric|min:1|exists:animals,id',
			'hit_0' => 'required|numeric|min:-1|max:1|not_in:0',
			'id_1' => 'required|numeric|min:1|exists:animals,id',
			'hit_1' => 'required|numeric|min:-1|max:1|not_in:0'
		]);
 	    
		if($validator->fails()){
			$errors = $validator->errors();
			return $this->respondValidationFailed($errors);
		}
		
		$this->updateHitsAndScoreInDB($request);
		return $this->respondUpdated("Score For Animals Updated");
	}
	#endregion
	
}