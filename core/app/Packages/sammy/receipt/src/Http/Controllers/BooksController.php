<?php

/**
 * Created by PhpStorm.
 * User: kalya
 * Date: 1/5/2016
 * Time: 10:24 AM
 */
namespace Sammy\Books\Http\Controllers;


use App\Http\Controllers\Controller;

use App\Models\booktype;
use App\Models\catagory;
use App\Models\centers;
use App\Models\subject;
use App\Models\piority;
use App\Models\type;
use App\Models\articals;
use Sammy\Books\Http\Requests\BooksRequest;
use Sammy\Books\Models\Books;
use Sammy\permissions\Models\Permission;
use Illuminate\Http\Request;
use Response;
use Sentinel;
use Hash;
use Activation;



class BooksController extends Controller
{

    /*
	|--------------------------------------------------------------------------
	| Document  Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the Document  Add screen to the user.
	 *
	 * @return Response
	 */
	public function addView()
	{
		$center = centers::all()->lists('location_name' , 'location_id' )->prepend('Select Center');
		$type = booktype::all()->lists('type' , 'id' )->prepend('Select Book Type');
        $subjects = subject::all()->lists('subject' , 'id' )->prepend('Select Subjects');
        $catgory = catagory::all()->lists('catagory' , 'id' )->prepend('Select Book Category');
		return view( 'Books::add' )->with([
            'center' => $center,
			'type' => $type,
            'subject'=>$subjects,
            'category'=>$catgory
		]);
	}

	/**
	 * Add new Document data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(BooksRequest $request)
	{
        $loggedUser=Sentinel::getUser();
		$credentials =Books::create([
			'branch'    => $request->get( 'center' ),
			'title' => $request->get('title' ),
			'isbn'=> $request->get('isbn' ),
			'author' => $request->get('author' ),
            'type' => $request->get('type' ),
            'subject' => $request->get('subject' ),
            'rack' => $request->get('rack' ),
            'shell' => $request->get('shell' ),
            'addby' =>$loggedUser->id,
			'catagory' => $request->get('category' )
		]);
		return redirect('books/list')->with([ 'success' => true,
			'success.message'=> 'Artical added successfully!',
			'success.title' => 'Well Done!']);


	}
	/**
	 * Show the user add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'Books::list' );
	}

	/**
	 * Show the user add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList()
	{
		$data = Books::all();
		$jsonList = array();
		$i=1;
		foreach ($data as $value) {
			$rowData= array();
            $branch=centers::where('location_id',$value->branch)->pluck('location_name');
			array_push($rowData,$i);
			array_push($rowData,$value->id);
			array_push($rowData,$value->title);
			array_push($rowData,$value->isbn);
            array_push($rowData,$value->author);
            array_push($rowData,$branch);



			$permissions = Permission::whereIn('name', ['books.edit', 'admin'])->where('status', '=', 1)->lists('name');

			if (Sentinel::hasAnyAccess($permissions)) {
				array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('books/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Type"><i class="fa fa-pencil"></i></a>');
			} else {
				array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
			}

			$permissions = Permission::whereIn('name', ['books.delete', 'admin'])->where('status', '=', 1)->lists('name');
			if (Sentinel::hasAnyAccess($permissions)) {
				array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Type"><i class="fa fa-trash-o"></i></a>');
			} else {
				array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled"><i class="fa fa-trash-o"></i></a>');
			}

			array_push($jsonList, $rowData);
			$i++;

		}
		return Response::json(array('data' => $jsonList));

	}

	/**
	 * Delete a Document
	 * @param  Request $request Document id
	 * @return Json           	json object with status of success or failure
	 */
	public function delete(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');
			$document = Document::find($id);
			if($document){
				$document->status = 2;
				$document->save();
				return response()->json(['status' => 'success']);
			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Show the Document type edit screen to the user.
	 *
	 * @return Response
	 */
	public function editView($id)
	{
		$books =  Books::find($id);
        $center = centers::all()->lists('location_name' , 'location_id' )->prepend('Select Center');
        $type = booktype::all()->lists('type' , 'id' )->prepend('Select Book Type');
        $subjects = subject::all()->lists('subject' , 'id' )->prepend('Select Subjects');
        $catgory = catagory::all()->lists('catagory' , 'id' )->prepend('Select Book Category');
		if($books){
			return view('Books::edit')->with([
				'books'=> $books,
                'center' => $center,
                'type' => $type,
                'subject'=>$subjects,
                'category'=>$catgory
			]);
		}else{
			return view('errors.404');
		}

	}

	/**
	 * Edit Document type data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(BooksRequest $request, $id)
    {
        {
            $loggedUser = Sentinel::getUser();
            $books = Books::find($id);
            $books->branch = $request->get('center');
            $books->title = $request->get('title');
            $books->isbn = $request->get('isbn');
            $books->author = $request->get('author');
            $books->type = $request->get('type');
            $books->subject = $request->get('subject');
            $books->rack = $request->get('rack');
            $books->shell = $request->get('shell');
            $books->addby = $loggedUser->id;
            $books->catagory = $request->get('category');
            $books->save();
            return redirect('books/list')->with(['success' => true,
                'success.message' => 'Artical Update successfully!',
                'success.title' => 'Well Done!']);

        }
    }

}