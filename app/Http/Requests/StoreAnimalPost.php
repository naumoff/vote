<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimalPost extends FormRequest {
	
	#region MAIN METHODS
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return TRUE;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'animal-name' => 'required',
			'type' => 'required',
			'subtype' => 'required',
			'photo' => 'required|'
		];
	}
	#endregion
	
	public function withValidator($validator)
	{
		$validator->after(function ($validator) {
//			$validator->errors()->add('field', 'Something is wrong with this field!');
		});
		
		if($validator->fails()){
			$inputs = $this->request->all();
			$this->saveInputsToSession($inputs);
		}
	}
	
	
	#region SERVICE METHODS
	private function saveInputsToSession($inputs)
	{
		foreach ($inputs AS $key=>$input)
		{
			if($key === 'animal-name'){
				session()->flash('animal-name',$input);
			}
			if($key === 'type'){
				session()->flash('type',$input);
			}
			if($key === 'subtype'){
				session()->flash('subtype',$input);
			}
		}
	}
	#endregion
}