<?php
namespace Sammy\TransportLogSheet\Http\Requests;

use App\Http\Requests\Request;

class TransportLogSheetRequest extends Request {

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
