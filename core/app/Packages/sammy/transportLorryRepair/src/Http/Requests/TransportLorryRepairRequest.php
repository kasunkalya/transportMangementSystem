<?php
namespace Sammy\TransportLorryRepair\Http\Requests;

use App\Http\Requests\Request;

class TransportLorryRepairRequest extends Request {

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
