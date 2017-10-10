<?php
class Controller{
	protected $_view;
	protected $_model;
	protected $_templateObj;
	
	// Params (GET - POST)
	protected $_arrParam;
	
	public function __construct($arrParams){
		$this->setModel($arrParams['module'], $arrParams['controller']);
		$this->setTemplate($this);
		$this->setView($arrParams['module']);
		$this->setParams($arrParams);
	}
	
	public function setModel($moduleName, $modelName){
		$modelName = ucfirst($modelName).'Model';
		$path = APPLICATION_PATH.$moduleName.DS.'models'. DS.$modelName.'.php';
		if(file_exists($path)){
			require_once $path;
			$this->_model = new $modelName();
		}
	}
	
	public function getModel(){
		return $this->_model;
	}
	
	public function setView($moduleName){
		$this->_view = new View($moduleName);
	}
	
	public function getView(){
		return $this->_view;
	}
	
	public function setTemplate(){
		$this->_templateObj = new Template($this);	
	}
	
	public function getTemplate(){
		return $this->_templateObj;
	}
	
	public function setParams($arrParam){
		$this->_arrParam= $arrParam;
	}
	
	public function getParams($arrParam){
		$this->_arrParam= $arrParam;
	}
}