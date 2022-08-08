<?php
namespace Sammy\TransportManagement\Http\Requests;

use App\Http\Requests\Request;

class TransportManagementRequest extends Request {

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
