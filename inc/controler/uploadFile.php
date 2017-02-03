  <?php

if (isset($index)){
  require_once "inc/model/files.php";

	function uploadFile(){

		$model = new files();

		$nameOrigin = $_FILES["files"]["name"];
		$date = date("Y-m-d H:i:s");

		$nameFolder = isset($_POST['folder']) ? $_POST['folder'] : null;

		if($fold = $model->getFold($nameFolder)){
			if($fold['statut'] == 0){				
				$path = $_FILES["files"]["tmp_name"];
				$type = $_FILES["files"]["type"];
				$size = $_FILES["files"]["size"];
				
				if(folderSize(FOLDER_UPL.$nameFolder."/") <= ((1024 * 1024) * 1024) * 4){
					if(is_array($nameOrigin)){
						$array_random = array();
						$array_name = array();
						$array_size = array();
						$array_error = array();
						$array_error_mess = array();

						for($i=0; $i < sizeof($nameOrigin); $i++){
							
							$extension = strrchr($nameOrigin[$i], ".");
							if(!in_array($extension, array(".php", ".exe", ".htaccess"))){	
								$array_error = array_merge($array_error, array(1));						
								$array_error_mess = array_merge($array_error_mess, array("ok"));						
								$nameFile = md5(uniqid());
								
								$nameShow = substr($nameOrigin[$i], 0, (strlen($nameOrigin[$i]) - strlen($extension)));
								
									if(file_exists(FOLDER_UPL.$nameFolder."/".$nameOrigin[$i])){
										$num = 1;
										while(file_exists(FOLDER_UPL.$nameFolder."/".$nameShow."($num)".$extension)){
											$num ++;
										}
										$nameShow =	$nameShow."(".($num).")";
									}
								
								
								$result = move_uploaded_file($_FILES['files']['tmp_name'][$i], FOLDER_UPL.$nameFolder."/".$nameShow.$extension);

								if ($result){
									$res = $model->saveFiles($nameFile, $nameOrigin[$i], $nameShow.$extension, $date, $fold['ID']);
									$array_random = array_merge($array_random, array($nameFile));
									$array_name = array_merge($array_name, array($nameShow.$extension));
									$array_size = array_merge($array_size, array(octetToOther($size[$i])));
								}
							}
							else{
								$array_error = array_merge($array_error, array(0));						
								$array_error_mess = array_merge($array_error_mess, array("l'extension $extension n'est pas pris en charge"));	
							}
								
							
						}						
						$reponse = array("STATUT" => 1, "CONTENT" => "Upload Ok", "ERRORFILE" => $array_error, "ERRORMESS" => $array_error_mess, "NAMEFILERDG" => $array_random, "NAMEORIGIN" => $array_name, "SIZEFILE" => $array_size);
					}
				}
				else{
					$reponse = array("STATUT" => 0, "CONTENT" => "Vous avez atteint la limite de 4GO ".folderSize(FOLDER_UPL.$nameFolder."/"));
				}
			}
			else{
				$reponse = array("STATUT" => 0, "CONTENT" => "Il n'est plus possible d'envoyer des fichiers, le dossier est fermé");
			}
		}
		else{
			$reponse = array("STATUT" => 0, "CONTENT" => "Le dossier n'existe pas");
		}
		
		echo json_encode($reponse);
	}

}
