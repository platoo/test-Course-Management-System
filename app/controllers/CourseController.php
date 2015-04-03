<?php

class CourseController extends BaseController {

	protected $layout = "layouts.main";

	public function __construct() {

		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('auth');
		View::share('active_nav', 'course');
		
	}

	public function getIndex() {
		
		$search = Session::get('course_search');
		$from = Session::get('course_from');
		$to = Session::get('course_to');
		$data['search'] = $search;
		$data['from'] = $from;
		$data['to'] = $to;
		//dd($from);
		if($from != '' && $to != '' ){
			$from = date("Y-m-d H:i:s", strtotime($from));
			$to = date("Y-m-d H:i:s", strtotime($to));
			$data['courses'] = Course::where('title','like','%'.$search.'%')
			->whereBetween('time', array($from, $to))
			->paginate(10);
		}else if($from != ''  ){
			$from = date("Y-m-d H:i:s", strtotime($from));
			$to = date("Y-m-d H:i:s", strtotime($to));
			$data['courses'] = Course::where('title','like','%'.$search.'%')
			->where('time', '>=',$from)
			->paginate(10);
		}else if($to != ''  ){
			$from = date("Y-m-d H:i:s", strtotime($from));
			$to = date("Y-m-d H:i:s", strtotime($to));
			$data['courses'] = Course::where('title','like','%'.$search.'%')
			->where('time', '<=',$to)
			->paginate(10);
		}else{
			$data['courses'] = Course::where('title','like','%'.$search.'%')->paginate(10);
		}
		
		$this->layout->content = View::make('courses.index', $data);
	}

	public function postIndex() {
		
		$search = Input::get('search');
		$from = Input::get('from');
		$to = Input::get('to');
		Session::put('course_search', $search);
		Session::put('course_from', $from);
		Session::put('course_to', $to);
//dd($search);
		return Redirect::to('course');
	}

	public function getClear() {
		
		$search = Session::forget('course_search');
		$search = Session::forget('course_from');
		$search = Session::forget('course_to');
		return Redirect::to('course');

	}

	public function getCreate() {
		if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' ){
			$data['method'] = 'Create';
			$data['categorys'] = category::all();

			$this->layout->content = View::make('courses.create_edit', $data);
		}else{
			return Redirect::to('course')->with('message', 'Can\'t Access');
		}
	}

	public function postCreate() {
		if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' ){

			$rules = array(
				'title'=>'required',
				'detail'=>'required',
				'category'=>'required',
				);

			$validator = Validator::make(Input::all(), $rules );
			if ($validator->passes()) {

				$title = Input::get('title');
				$detail = Input::get('detail');
				$category = Input::get('category');
				$time = Input::get('time');
				$amount = Input::get('amount');
				
				$course = new Course;

				$course->title 			= $title;
				$course->detail 		= $detail;
				$course->category_id 	= $category;
				$course->time 			= date("Y-m-d H:i:s", strtotime($time));
				$course->amount 		= $amount;
				$course->created_by 		= 1;

				$course->save();

				return Redirect::to('course')->with('message', 'create complete');;
			}else{
				return Redirect::to('course/create/')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
				
			}
		}else{
			return Redirect::to('course')->with('message', 'Can\'t Access');
		}
	}

	public function getEdit($id) {
		if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' ){
			$data['method'] = 'Edit';
			$data['course'] = Course::find($id);
			$data['categorys'] = category::all();

			$this->layout->content = View::make('courses.create_edit', $data);
		}else{
			return Redirect::to('course')->with('message', 'Can\'t Access');
		}
	}

	public function postEdit($id) {
		if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' ){

			$rules = array(
				'title'=>'required',
				'detail'=>'required',
				'category'=>'required',
				);

			$validator = Validator::make(Input::all(), $rules );
			if ($validator->passes()) {

				$title = Input::get('title');
				$detail = Input::get('detail');
				$category = Input::get('category');
				$time = Input::get('time');
				$amount = Input::get('amount');

				$course = Course::find($id);
				$course->title 			= $title;
				$course->detail 		= $detail;
				$course->category_id 	= $category;
				$course->time 			= date("Y-m-d H:i:s", strtotime($time));
				$course->amount 		= $amount;
				$course->created_by 		= 1;

				$course->save();

				return Redirect::to('course')->with('message', 'Update complete');
			}else{
				return Redirect::to('course/create/')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
				
			}
		}else{
			return Redirect::to('course')->with('message', 'Can\'t Access');
		}
	}

	public function getDelete($id) {
		if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' ){
			$data['method'] = 'Delete';
			$data['categorys'] = category::all();
			$data['course'] = Course::find($id);

			$this->layout->content = View::make('courses.create_edit', $data);
		}else{
			return Redirect::to('course')->with('message', 'Can\'t Access');
		}
	}

	public function postDelete($id) {
		if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' ){
			$course = Course::find($id);
			$course->delete();

			return Redirect::to('course');
		}else{
			return Redirect::to('course')->with('message', 'Can\'t Access');
		}
	}
}
