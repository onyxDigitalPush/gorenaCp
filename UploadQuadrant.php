<?php
include 'autoloader.php';
$dto = new AdminApiImpl();
$target_dir = './Captures/';
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$dataup = $_POST["dataup"];
$idsubemp = $_POST["idsubemp"];

// Check file existance
if ($_FILES["fileToUpload"]["name"] == "") {
    echo "Sorry, your file is empty.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $dto->getDb()->executarSentencia('insert into pujadaquad (datahora,dataact,idsubempresa,rutadoc) values (now(),"'.$dataup.'",'.$idsubemp.',"'.$target_file.'")');        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
unset($_POST);

?>