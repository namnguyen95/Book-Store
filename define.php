<?php
	// ====================== PATHS ===========================
	define ('DS'				, DIRECTORY_SEPARATOR); // '/' or '\'
	define ('DOMAIN'			,'http://bookstore.com/');
	define ('ROOT_PATH'			, __DIR__);

	define ('LIBRARY_PATH'		, ROOT_PATH.DS.'libs'.DS);
	define ('PUBLIC_PATH'		, ROOT_PATH.DS.'public'.DS);
	define ('APPLICATION_PATH'	, ROOT_PATH.DS.'application'.DS);
	define ('TEMPLATE_PATH'		, PUBLIC_PATH.'template'.DS);
	
	define	('ROOT_URL'			, DS . 'bookstore' . DS);
	define	('APPLICATION_URL'	, ROOT_URL . 'application' . DS);
	define	('PUBLIC_URL'		, ROOT_URL . 'public' . DS);
	define	('TEMPLATE_URL'		, PUBLIC_URL . 'template' . DS);
	
	define	('DEFAULT_MODULE'		, 'default');
	define	('DEFAULT_CONTROLLER'	, 'index');
	define	('DEFAULT_ACTION'		, 'index');

	// ====================== DATABASE ===========================
	define ('DB_HOST'	, 'localhost');
	define ('DB_USER'	, 'root');						
	define ('DB_PASS'	, '');						
	define ('DB_NAME'	, 'manage_user');						
	define ('DB_TABLE'	, 'user');						
