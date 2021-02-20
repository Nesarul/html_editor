<?php
if(isset($_FILES['file']['name'])){
   $tNow = new DateTime();
   $fName = $tNow->getTimestamp();
   $target_file = "../../images/$fName";
   $ft= basename($_FILES['file']['name']);
   $uploadOk = 1;
   $imageFileType = strtolower(pathinfo($ft,PATHINFO_EXTENSION));
   $target_file.='.'.$imageFileType;
   $fName.='.'.$imageFileType;
   // Check if image file is a actual image or fake image
   if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["file"]["tmp_name"]);
      if($check !== false) {
         echo "File is an image - " . $check["mime"] . ".";
         $uploadOk = 1;
      } else {
         echo "File is not an image.";
         $uploadOk = 0;
      }  
   }

   // Check if file already exists
   if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
   }

   // Check file size is smaller then 50mb. 
   if ($_FILES["file"]["size"] > 52428800) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
   }

   // Allow certain file formats
   if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
   }

   // Check if $uploadOk is set to 0 by an error
   if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
   } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
         $filetowrite1 = '../images/'.$fName;
         echo json_encode(array('location' => $filetowrite1));
      } else {
         echo "Sorry, there was an error uploading your file.";
      }
   }

}
