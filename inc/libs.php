<?php

	session_start();

	require_once("libs/Mustache/Autoloader.php");
	require_once("libs/AltoRouter/AltoRouter.php");
	
	require_once(".init.php");
	require_once("libs/pdo/pdo.class.php");
	
	Mustache_Autoloader::register();

	$router = new AltoRouter();
	
	$router->setBasePath(URL_FOLDER);
	
	require_once("functions.php");