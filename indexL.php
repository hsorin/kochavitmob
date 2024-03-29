<?php include '../includes/header.php'; ?>

<form method="POST" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
  <input type="file" name="pictures" accept="image/*"/>
  <input type="submit" value="upload"/>
</form>

<?php
require_once  "../bulletproof/src/bulletproof.php";

$image = new Bulletproof\Image($_FILES);

if($image["pictures"]){
  $upload = $image->upload(); 

  if($upload){
    echo $upload->getFullPath(); // uploads/cat.gif
  }else{
    echo $image->getError(); 
  }
}
?>
<?php  include '../includes/footer.php'; ?>