<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
