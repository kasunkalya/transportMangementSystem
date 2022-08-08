<?php
namespace Sammy\TransportCompany\Http\Requests;

use App\Http\Requests\Request;
//use Input;

class TransportCompanyRequest extends Request
{
    public function authorize(){
        return true;
    }

    public function rules(){

        //if(Input::get('document_name') != NULL){
        $rules = [
//            'article_name'=>'required',
//            'piority' => 'required',
//            'article' => 'required',
//            'image' => '',
//            'sammary'=> '',
//            'type' => 'required'
        ];
//        } else{
//            $rules = [
//                'document_name'=>'required',
//                'description' => 'required',
//                'verify' => 'required'
//
//            ];
//        }

        return $rules;
    }


}