<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kitten extends Animal
{
	protected $table = 'kittens';
	protected $fillable = [
		'animal_id',
		'fur'
	];
	
	#region RELATION METHODS
	public function animal()
	{
		return $this->belongsTo(Animal::class);
	}
	#endregion
}
