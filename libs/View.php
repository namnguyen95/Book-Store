<?php
class View{
	public $_moduleName;
	public $_templatePath;
	public $_title;
	public $_metaHTTP;
	public $_metaName;
	public $_cssFiles;
	public $_jsFiles;
	public $_dirImg;
	public $_fileView;
	
	function __construct($moduleName){
		$this->_moduleName = $moduleName;
	}
	
	function setTemplatePath($path){
		$this->_templatePath = $path;
	}

	function render($fileInclude, $loadFull = true){
		$path = APPLICATION_PATH.$this->_moduleName.DS.'views'.DS.$fileInclude.'.php';
		if(!file_exists($path)){
			echo '<h3>'.__METHOD__ .': Error</h3>';
			return;
		}

		if($loadFull == true){
			$this->_fileView = $fileInclude;
			$this->setTemplatePath($path);//
			require_once($this->_templatePath);
		}
		else{
			require_once($path);
		}
	}
	
	// CREATE CSS - JS
	function createLink($path, $files, $type = 'css'){
		if (empty($files)){
			return;
		}

		$xhtml = '';
		$path = TEMPLATE_URL.$path.DS;
		foreach($files as $file){
			if($type == 'css'){
				$xhtml .= '<link rel="stylesheet" type="text/css" href="'.$path.$file.'"/>';
			}
			else if($type == 'js'){
				$xhtml .= '<script type="text/javascript" src="'.$path.$file.'"></script>';
			}
		}
		return $xhtml;
	}
	
	// CREATE META (NAME - HTTP)
	function createMeta($arrMeta, $typeMeta = 'name'){
		if (empty($arrMeta)) {
			return;
		}

		$xhtml = '';
		foreach($arrMeta as $meta){
			$temp = explode('|', $meta);
			$xhtml .= '<meta '.$typeMeta.'="'.$temp[0].'" content="'.$temp[1].'" />';
		}
		return $xhtml;
	}
	
	function createTitle($value){
		return '<title>'.$value.'</title>';
	}
	
	function setTitle($value){
		$this->_title = '<title>'.$value.'</title>';
	}
	
	// SET CSS
	function appendCSS($arrayCSS){
		if(!empty($arrayCSS)){
			foreach ($arrayCSS as $css){
				$file = APPLICATION_URL.$this->_moduleName.DS.'views'.DS.$css;
				$this->_cssFiles .= '<link rel="stylesheet" type="text/css" href="'.$file.'"/>';
			}
		}
	}
	
	// SET JS
	function appendJS($arrayJS){
		if(!empty($arrayJS)){
			foreach ($arrayJS as $js){
				$file = APPLICATION_URL.$this->_moduleName.DS.'views'.DS.$js;
				$this->_jsFiles .= '<script type="text/javascript" src="'.$file.'"></script>';
			}
		}
	}
}