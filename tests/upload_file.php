<?php
    if ($_FILES["file"]["name"] != ''){
        $saveName = $_POST["newName"];
        echo $saveName;
        $fileName = $_FILES['file']['name'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));   
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        if ($fileError === 0){
            $fileNameNew = $saveName.".".$fileActualExt;
            $fileDest = '../files_from_web/documents/'.$fileNameNew;
            move_uploaded_file($fileTmpName, $fileDest);
        }
    }
    else {
        echo "<script>alert('לא צורף מסמך...')</script>";
    }

//    $preview = $_POST['img_value'];
//    $preview = str_replace('data:image/jpeg;base64,', '', $preview);
//    $preview = str_replace(' ', '+', $preview);
//    $data = base64_decode($preview);
//    $target = '../files_from_web/documents/test22.jpg';
//    if (file_put_contents($target, $data)){
//        echo 'done';
//    }else{
//        echo 'failed';
//    }
?>
