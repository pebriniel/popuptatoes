<?php

/*
	@TODO : /createArchive/ à revoir
*/

require_once("inc/libs.php");

$router->map('GET', '/', function(){
	$load = true;
	mustacheLoad('body');
}, 'home');

$router->map('GET', '/404/', function(){
	mustacheLoad('404');	
}, '404');

//ajax création d'archive custom
$router->map('POST', '/downloadCustomArchive/', function(){
	$index = true;
	require_once "inc/controler/CustomArchive.php";
	echo customCreateArchive();
	
}, 'downloadCustomArchive');

//ajax création d'archive custom
$router->map('GET', '/cron/', function(){
	$index = true;
	require_once "inc/controler/Cron.php";
	cronDeleteFile();
}, 'cron');

//l'utilisateur finalise l'envoie 
$router->map('GET', '/folder/[h:key]/', function($key){
	$index = true;
	require_once "inc/controler/PageShare.php";
	$arrayTpl = CTRLPageShare($key);
	mustacheLoad('folder', $arrayTpl);
	
}, 'folder');

//l'utilisateur finalise l'envoie 
$router->map('GET', '/download/[h:key]/[h:keyUser]/', function($key, $keyUser){
	$index = true;
	require_once "inc/controler/downloadArchive.php";
	$arrayTpl = downloadArchive($key, $keyUser);
}, 'download');

//on affiche la liste des dossiers
$router->map('GET', '/share/[h:keyFold]/[h:keyUser]/', function($keyFold, $keyUser){
	$index = true;
	
	require_once "inc/controler/Share.php";
	$arrayTpl = CTRL_LoadShare($keyUser, $keyFold, __dir__);
	
	mustacheLoad('share', $arrayTpl);
}, 'share');

//on affiche la liste des dossiers
$router->map('GET', '/share/[h:keyFold]/', function($keyFold){
	$index = true;
	
	require_once "inc/controler/Share.php";
	$arrayTpl = CTRL_LoadShare(null, $keyFold, __dir__);
	
	mustacheLoad('share', $arrayTpl);
}, 'shareSolo');

$router->map('POST', '/uploadAjax/', function(){
	$index = true;
	require_once "inc/controler/Infosaved.php";

	LaunchInfoSaved();
	
}, 'uploadAjax');

$router->map('POST', '/deleteFileAjax/', function(){
	$index = true;
	require_once "inc/controler/DeleteFile.php";

	CTRL_deleteFile();
}, 'deleteFileAjax');

$router->map('POST', '/UPLfiles/', function(){
	$index = true;
	require_once "inc/controler/uploadFile.php";

	uploadFile();

}, 'UPLfiles');


$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {			
	call_user_func_array( $match['target'], $match['params'] );
} else {
	// no route was matched
	header("Location: ".URL_."404/");
	//header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}