<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public static function getAllUsersIds()
    {
    	return self::all('id')->toArray();
    }
    
    #region RELATION METHODS
	public function animals()
	{
		return $this->hasMany(Animal::class,'id','owner_id');
	}
	#endregion
}
