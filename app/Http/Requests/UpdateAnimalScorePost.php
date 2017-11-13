<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimalScorePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	        "id_0" => 'required|numeric|min:1|exists:animals,id',
            "hit_0" => 'required|numeric|min:-1|max:1|not_in:0',
            "id_1" => 'required|numeric|min:1|exists:animals,id',
            "hit_1" => 'required|numeric|min:-1|max:1|not_in:0'
        ];
    }
}
