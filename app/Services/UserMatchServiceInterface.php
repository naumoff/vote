<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 09.11.2017
 * Time: 9:39
 */

namespace App\Services;


interface UserMatchServiceInterface {
	
	public function saveMatchesForUser();
	public function takeMatchForUser();
}