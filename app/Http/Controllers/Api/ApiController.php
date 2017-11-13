<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 12.11.2017
 * Time: 20:42
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
	protected $statusCode = 200; // default status code
	
	#region SUCCESS METHODS
	public function respondCreated($message)
	{
		return $this->setStatusCode(201)->respond([
			'status' => 'created',
			'message' => $message
		]);
	}
	
	public function respondUpdated($message = 'entity updated')
	{
		return $this->setStatusCode(202)->respond([
			'status' => 'updated',
			'message' => $message
		]);
	}
	#endregion
	
	#region FAILURE METHODS
	public function respondWithError($message)
	{
		return $this->respond([
			'error' => [
				'message' => $message,
				'status_code' => $this->getStatusCode()
			]
		] // = 1st param - $data
		);
	}
	
	public function respondNotFound($message = 'Not Found')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}
	
	public function respondValidationFailed($message = "")
	{
		return $this->setStatusCode(422)->respondWithError($message);
	}
	#endregion
	
	#region SERVICE METHODS
	public function respond($data, $headers = [])
	{
		return Response::json($data, $this->getStatusCode(),$headers);
	}
	public function getStatusCode()
	{
		return $this->statusCode;
	}
	
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}
	#endregion
}