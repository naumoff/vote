<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Animal extends Model
{
    protected $table = 'animals';
	protected $fillable = [
		'owner_id',
		'type',
		'name',
		'photo',
		'victories',
		'failures',
		'score'
	];
	
	#region MAIN METHODS
	public static function fetchAnimals()
	{
		$animals = self::orderBy('score','desc')
			->get([
				'id',
				'type',
				'name',
				'photo'
			])
			->toArray();
		return $animals;
	}
	
	public static function getUserAnimals($userID, $perPage=10)
	{
		$userAnimals = self::with('kitten','puppy')
			->where('owner_id','=',$userID)
			->orderBy('score','desc')
			->simplePaginate($perPage);
		return $userAnimals;
	}
	
	public static function getTopScoreAnimals($perPage = 10)
	{
		$topAnimals = self::with('user')
			->orderBy('score','desc')
			->simplePaginate($perPage);

		return $topAnimals;
	}
	#endregion
 
	#region RELATION METHODS
	public function user()
	{
		return $this->belongsTo(User::class,'owner_id','id');
	}
	
	public function kitten()
	{
		return $this->hasOne(Kitten::class);
	}
	
	public function puppy()
	{
		return $this->hasOne(Puppy::class);
	}
	#endregion
 
}
