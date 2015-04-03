<?php

class DashboardController extends BaseController {

	protected $layout = "layouts.main";

	public function __construct() {

    	$this->beforeFilter('csrf', array('on'=>'post'));
    	$this->beforeFilter('auth');

    	View::share('active_nav', 'dashboard');
	}

	public function getIndex() {
		$this->layout->content = View::make('dashboards.index');
	}
}
