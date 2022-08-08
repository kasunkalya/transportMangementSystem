<?php
namespace Sammy\TransportCustomer\Http\Requests;

use App\Http\Requests\Request;

class TransportCustomerRequest extends Request {

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
