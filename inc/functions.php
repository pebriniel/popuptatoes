<?php

function mustacheLoad($html, $array = null){
	$mustache_options =  array('extension' => EXT_MU_TPL);
	$m = new Mustache_Engine(array(
		'loader' => new Mustache_Loader_FilesystemLoader(TPL_EMP, $mustache_options),
	));
	
	$_array = array('URL_' => URL_);
	if(is_array($array)){
		$_array = array_merge($_array, $array);
	}
	
	echo $m->render($html, $_array);	
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

//suppression d'un dossier et de ces fichiers de façon récurcif
function rmdir_recursive($dir) {
	foreach(scandir($dir) as $file) {
		if ('.' === $file || '..' === $file) continue;
		if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
		else unlink("$dir/$file");
	}
	rmdir($dir);
}


//taille d'un dossier, calcul récurcif
function folderSize ($dir)
{
	$size = 0;
	foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
		$size += is_file($each) ? filesize($each) : folderSize($each);
	}
	return $size;
}

/* transformation des ockets en mo/gb etc.*/
function octetToOther($size){
	$base = log($size) / log(1024);
	$suffix = array("", "k", "M", "G", "T")[floor($base)];
	return intval(pow(1024, $base - floor($base))) . $suffix;
}