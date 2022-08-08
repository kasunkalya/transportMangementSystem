<?php
namespace Sammy\TransportLorryChargers\Http\Requests;

use App\Http\Requests\Request;

class TransportLorryChargersRequest extends Request {

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
