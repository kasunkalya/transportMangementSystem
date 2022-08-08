<?php
namespace Sammy\UserManage\Http\Requests;

use App\Http\Requests\Request;
use Input;

class UserRequest extends Request {

	public function authorize(){
		return true;
	}

	public function rules(){    

	if(Input::get('password') != NULL){
		$rules = [
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email',
			'username' => 'required|min:6',
			'password' => 'required|confirmed|min:6'
		];
	} else{
		$rules = [
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email',
			'username' => 'required|min:6',
			
		];
	}
		
		return $rules;
	}

}
