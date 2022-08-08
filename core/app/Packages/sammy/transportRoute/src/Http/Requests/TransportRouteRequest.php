<?php
namespace Sammy\TransportRoute\Http\Requests;

use App\Http\Requests\Request;

class TransportRouteRequest extends Request {

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
