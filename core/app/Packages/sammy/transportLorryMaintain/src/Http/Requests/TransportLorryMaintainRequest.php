<?php
namespace Sammy\TransportLorryMaintain\Http\Requests;

use App\Http\Requests\Request;

class TransportLorryMaintainRequest extends Request {

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
