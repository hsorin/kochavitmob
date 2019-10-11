<?php
    $filename = $_FILES['file']['name'];
    $location = '../files_from_web/documents/';
    $uploadOk = 1;
    $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
    
    $valid_extension = array("jpg", "jpeg", "png");
    if (!in_array(strtolower($imageFileType), $valid_extension)){
        $uploadOk = 0;
    }
    if ($uploadOk == 0){
        echo 0;
    } else {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)){
            echo $location; 
        } else {
            echo 0;
        }
    }
?>