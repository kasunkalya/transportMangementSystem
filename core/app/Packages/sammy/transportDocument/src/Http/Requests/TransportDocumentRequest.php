<?php
namespace Sammy\TransportDocument\Http\Requests;

use App\Http\Requests\Request;

class TransportDocumentRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
//			'customer_name' => 'required',
//			'name' => 'required'
			];
		return $rules;
	}

}
