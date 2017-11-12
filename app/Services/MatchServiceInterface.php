<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 08.11.2017
 * Time: 9:03
 */

namespace App\Services;


interface MatchServiceInterface {
	public function compileMatchMap();
	public function saveMatchMap();
	public function getMatchMap();
}