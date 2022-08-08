<?php
namespace Sammy\TransportLorry\Http\Requests;

use App\Http\Requests\Request;

class TransportLorryRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
//			'code' => 'required',
//			'name' => 'required'
			];
		return $rules;
	}

}
