<?php

if(isset($index)){
	require_once "inc/model/share.php";
	require_once "inc/libs/mail/mail.php";
	
	function downloadArchive($keyFold, $keyUser){
		$model = new sharePDO();
		
		if(!is_null($keyUser) && $user = $model->SQL_Receiver($keyUser, $keyFold)){
			if($user['download'] == 0){
				$model->updateDownloadUser($user['iReceiver']);
				$url_download = URL_."share/".$user['Name']."/";			
				function_mail($user['EmailExp'], $user['EmailReceiver']." a téléchargé l'archive", "download", array("DEST" => $user['EmailReceiver'], "URL" => $url_download));
			}
		}
	}
}