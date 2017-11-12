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
			'photo' => 'required|file|image|max:1000|dimensions:max_width=700,max_height=700, min_width:100, min_height:200'
		];
	}
	#endregion
	
	public function withValidator($validator)
	{
		$validator->after(function ($validator) {
			$errors = $validator->errors();
			if($errors->has('photo')){
				foreach ($errors->get('photo') AS $message){
					if($message == 'The photo has invalid image dimensions.'){
						$validator->errors()->add('photo', 'max width: 700 pixels & max height:700 pixels');
						$validator->errors()->add('photo', 'min width: 100 pixels & min height:200 pixels');
					}
				}
			}
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