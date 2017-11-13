<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 13.11.2017
 * Time: 16:13
 */

namespace App\Services\Traits;


trait GetPhotoPath {
	#region SERVICE METHODS
	private function getPhotoPath($photo)
	{
		$domainName = $_ENV['APP_URL'].'/';
		$pathName = str_replace('public', 'storage', $photo);
		$fullUrl = $domainName.$pathName;
		return $fullUrl;
	}
	#endregion
}