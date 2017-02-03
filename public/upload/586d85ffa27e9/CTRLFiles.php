  <?php

if (isset($index)){
  require_once "inc/model/files.php";

  echo "coucou";

  function CTRL_FilesSaved(){

      $model = new files();

      $nameOrigin = $_FILES["files"]["name"];
      $date = date("Y-m-d H:i:s");

      $nameFolder = isset($_POST['folder']) ? $_POST['folder'] : null;

      if($model->getFold($nameFolder)){

        $path = $_FILES["files"]["tmp_name"];
        $type = $_FILES["files"]["type"];

        //if (isset($_POST['submit'])){

          if(is_array($nameOrigin)){

            for($i=0; $i < sizeof($nameOrigin); $i++){
              $nameFile = md5(uniqid());

              $result = move_uploaded_file($_FILES['files']['tmp_name'][$i], FOLDER_UPL.$nameFolder."/".$nameOrigin[$i]);

              if ($result){
                $res = $model->saveFiles($nameFile, $nameOrigin[$i], $date, $nameFolder);
                echo "Transfert ok";
              }
            }
          //}

        }
      }
      else{
        echo "le dossier n'existe pas";
      }
  }

}
