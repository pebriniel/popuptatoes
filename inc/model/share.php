<?php

class sharePDO extends SQLpdo{
		
	public function __construct(){
		$this->connexion();
	}
	
	function SQL_Receiver($keyUser, $keyFold){
		return $user = $this->fetch("SELECT NbrVisit, Name, EmailReceiver, EmailExp, download, f.ID AS iFold, NameFold, r.ID AS iReceiver FROM ".PREFIX_DB."Receiver r LEFT JOIN ".PREFIX_DB."Fold f ON r.NameFold = f.ID WHERE UserKey = :userKey AND f.Name = :NameFold", array(':userKey' => $keyUser, ':NameFold' => $keyFold));
	}
	
	function getFold($key){
      $sql = "SELECT *, ID as iFold FROM ".PREFIX_DB."Fold WHERE Name = :name";
      $execute =  array(
          ":name" => $key,
        );


      return $file = $this->fetch($sql, $execute);
    }
	
	function SQL_ReceiverUpdate($visit, $key){
		$this->update("UPDATE ".PREFIX_DB."Receiver SET NbrVisit = :nbvisit WHERE UserKey = :userKey", 
								array(
									':nbvisit' => ($visit + 1),
									':userKey' => $key));
	}
	
	function SQL_ListFile($fold){
		return $this->fetchAll("SELECT *, DATE_FORMAT(Date,'%d-%m-%Y %H:%i:%s') AS dateFR FROM ".PREFIX_DB."File WHERE NameFold = :IDfold ", array(':IDfold' => $fold));;
	}
	
	function updateDownloadUser($id){
		$this->update("UPDATE ".PREFIX_DB."Receiver SET download = 1 WHERE ID = :id", array(":id" => $id));
	}
}