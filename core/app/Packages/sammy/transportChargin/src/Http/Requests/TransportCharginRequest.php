<?php
namespace Sammy\TransportChargin\Http\Requests;

use App\Http\Requests\Request;

class TransportCharginRequest extends Request {

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
