<?php 
include "db.php"; 

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "SELECT `user_image` FROM `register` WHERE `id`='$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['user_image'];
    }

    if (!empty($image_path) && file_exists($image_path)) { 
        unlink($image_path);
    }

    $sql = "DELETE FROM `register` WHERE `id`='$user_id'";
    $result = $conn->query($sql);

    if ($result == TRUE) {
        echo "<script type='text/javascript'>alert('Record Deleted Successfully');location='user_data.php';</script>";
    } else {
        echo "Error:" . $sql . "<br>" . $conn->error;
    }
} 
?>
