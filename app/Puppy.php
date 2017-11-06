<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puppy extends Animal
{
	protected $table = 'puppies';
	protected $fillable = [
		'animal_id',
		'type'
	];
	
	#region RELATION METHODS
	public function animal()
	{
		return $this->belongsTo(Animal::class);
	}
	#endregion
}
