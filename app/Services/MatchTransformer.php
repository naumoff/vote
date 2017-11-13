<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 12.11.2017
 * Time: 21:20
 */

namespace App\Services;


use App\Animal;
use Illuminate\Http\Request;

class MatchTransformer
{
	public function transform($match)
	{
		return [
			"id_0" => $match['id_0'],
		    "name_0" => $match['name_0'],
		    "type_0" => $match['type_0'],
		    "photo_0" => $this->getPhotoPath($match['type_0'],$match['photo_0']),
			"score_0" => $match['score_0'],
		    "id_1" => $match['id_1'],
		    "name_1" => $match['name_1'],
		    "type_1" => $match['type_1'],
		    "photo_1" => $this->getPhotoPath($match['type_1'],$match['photo_1']),
			"score_1" => $match['score_1'],
		];
	}
	
	#region SERVICE METHODS
	private function getPhotoPath($type, $photo)
	{
		$domainName = $_ENV['APP_URL'].'/';
		$pathName = str_replace('public', 'storage', $photo);
		$fullUrl = $domainName.$pathName;
		return $fullUrl;
	}
	#endregion
}