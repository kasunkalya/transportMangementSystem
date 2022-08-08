<?php
namespace Sammy\TransportEmployee\Http\Requests;

use App\Http\Requests\Request;

class TransportEmployeeRequest extends Request {

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
