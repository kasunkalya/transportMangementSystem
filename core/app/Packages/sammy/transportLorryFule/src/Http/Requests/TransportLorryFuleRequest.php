<?php
namespace Sammy\TransportLorryFule\Http\Requests;

use App\Http\Requests\Request;

class TransportLorryFuleRequest extends Request {

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
