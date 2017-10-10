<?php
class ErrorController extends Controller{
	function __construct(){
	}

	function indexAction(){
		$this->_view->data	= '<h3>This is an error!</h3>';
		$this->_view->render('error/index');
	}
}