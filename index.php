<?php
	require_once 'define.php';

	function printArr($something){
		echo "<pre style='color:#F60'>";
		print_r($something);
		echo "</pre>";
	}

	function __autoload($className){
		if (file_exists(LIBRARY_PATH.$className.'.php')) {
			require_once LIBRARY_PATH.$className.'.php';
		}
	}
	$bootstrap = new Bootstrap();
	$bootstrap->init();