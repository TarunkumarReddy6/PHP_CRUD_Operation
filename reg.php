<?php
include "db.php";

if (isset($_POST['submit'])) {
  $folder = "images/";
  $filename = $_FILES["uploadfile"]["name"];
  $tempname = $_FILES["uploadfile"]["tmp_name"];
  $new = uniqid()."_".$filename;    
  $new_image_path = $folder . $new;
  // Validate file type
  $allowedExtensions = array("jpg", "jpeg", "png", "gif");
  $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
  
  if (!in_array($fileExtension, $allowedExtensions)) {
    echo "<script type='text/javascript'>alert('Invalid file type. Please upload an image.');location='register.php';</script>";
    exit;
  }
  
  move_uploaded_file($tempname, $new_image_path);
  $name = $_POST['name'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $password = $_POST['password'];  
  
if (!preg_match ("/^[0-9]*$/", $phone) ){ 
  echo "<script type='text/javascript'>alert('Only numeric value is allowed.');location='register.php';</script>";
}

  $sql_1 = "SELECT * FROM register WHERE email = '$email'";
  $res_1 = mysqli_query($conn, $sql_1);
  
  if (mysqli_num_rows($res_1) > 0) {
    echo "<script type='text/javascript'>alert('Email already taken');location='login.php';</script>";
    exit;
  }

  $sql = "INSERT INTO `register`(`name`, `address`, `phone`, `email`, `user_image`, `password`) VALUES ('$name', '$address', '$phone', '$email', '$new_image_path', '$password')";
  
  $result = $conn->query($sql);

  if ($result === TRUE) {
    echo "<script type='text/javascript'>alert('Record Saved Successfully');location='register.php';</script>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>
