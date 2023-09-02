<?php 
session_start();
include "db.php";
if(!isset($_SESSION['valid'])){
    header('Location:login.php');
}
$sql = "SELECT * FROM register";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>- Project Details</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons 
  <link href="assets/img/favicon.png" rel="icon">-->
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="css/auth.css" rel="stylesheet"/>

  <!-- =======================================================
  * Template Name: UpConstruction - v1.3.0
  * Template URL: https://bootstrapmade.com/upconstruction-bootstrap-construction-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<?php
include "db.php";

if (isset($_GET['id'])) {
  $user_id = $_GET['id'];
  $sql = "SELECT * FROM `register` WHERE `id` = $user_id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    if ($row = $result->fetch_assoc()) {
      $name = $row['name'];
      $address = $row['address'];
      $phone = $row['phone'];
      $email = $row['email'];
      $image = $row['user_image'];
      $password = $row['password'];
    }

    if (isset($_POST['submit'])) {
      $folder = "images/";
      $filename = $_FILES["uploadfile"]["name"];
      $tempname = $_FILES["uploadfile"]["tmp_name"];
      $new = uniqid()."_".$filename;    
      $new_image_path = $folder . $new;
      $id = $_POST['up_id'];
      $name = $_POST['name'];
      $address = $_POST['address'];
      $phone = $_POST['phone'];
      $new_email = $_POST['email'];
      $password = $_POST['password'];

      $error_messages = array();

      if (!preg_match ("/^[0-9]*$/", $phone)) {
        $error_messages[] = "Only numeric value is allowed in the phone number field.";
      }

      if ($_FILES["uploadfile"]["size"] > 0) {
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
          $error_messages[] = "Invalid file type. Please upload an image.";
        }
      }

      if ($new_email != $email) {
        $sql_check_email = "SELECT * FROM register WHERE email = '$new_email'";
        $result_check_email = mysqli_query($conn, $sql_check_email);

        if (mysqli_num_rows($result_check_email) > 0) {
          $error_messages[] = "Email already exists in another entry. Please choose a different email.";
        }
      }

      if (!empty($error_messages)) {

        foreach ($error_messages as $error) {
          echo "<script type='text/javascript'>alert('$error');</script>";
        }
      } else {
        if ($_FILES["uploadfile"]["size"] > 0) {
          if (!empty($image) && file_exists($image)) {
            unlink($image);
          }
          move_uploaded_file($tempname, $new_image_path);
          $image = $new_image_path;
        }

        $sql = "UPDATE `register` SET `name`='$name', `address`='$address', `phone`='$phone', `email`='$new_email', `user_image`='$image', `password`='$password' WHERE `id`='$user_id'";
        if ($conn->query($sql) === true) {
          echo "<script type='text/javascript'>alert('Updated successfully'); location='edit_form.php?id=" . $id . "';</script>";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    }
  }
}
?>




  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>UpConstruction<span>.</span></h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar">
        <ul>
        <li><a href="index.php" class="active">Home</a></li>
          <li><a href="about.html">About</a></li>
            <?php
            if(!isset($_SESSION['valid'])){
              ?>
              <li><a href="login.php">Login</a></li>          
              <li><a href="register.php">Signup</a></li>
            <?php 
               }
            else{
             ?> 
            <li><a href="user_data.php">user_data</a></li>     
            <li><a href="logout.php">Logout</a></li>
           <?php }
            ?>
        </ul>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/breadcrumbs-bg.jpg');">
      <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

        

        

            
      </div>

    </div><!-- End Breadcrumbs -->

    <main style="margin-top:400px"; class="box">
    <h2>Edit User Details</h2>
    <form action="edit_form.php?id=<?php echo $user_id; ?>" method="post" enctype="multipart/form-data">        
    <div class="inputBox">
        <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Name" required>
      <input type="hidden" name="up_id" value="<?php echo $user_id; ?>">
        </div>
        <div class="inputBox">
        <label for="address">Address:</label>
      <input type="text" id="address" name="address" value="<?php echo $address; ?>" placeholder="Address" required>
        </div>
        <div class="inputBox">
        <label for="phone">Phone:</label>
      <input type="phone" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="Phone" maxlength="10" required>

        </div>
        
        <div class="inputBox">
        <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Email" required>
        </div>
        <div class="inputBox">
        <img width="200px" height="auto" src="<?php echo $image; ?>">   
      <label for="image">image:</label>
      <input type="file" accept="image/png, image/png, image/jpeg" id="file" onchange="return fileValidation()" id="image" name="uploadfile">
        </div>
        <div class="inputBox">
        <label for="password">Password:</label>
      <input type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder="Password" required>
        </div>
        <button type="submit" name="submit" style="float: left;">Submit</button>
        <a class="button" href="user_data.php" style="float: left;">Userdata</a>
    </form>
</main>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer style="margin-top:1089px"; id="footer" class="footer">
    <div class="footer-content position-relative">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6">
            <div class="footer-info">
              <h3>MeConstruction</h3>
              <p>
                A108 Adam Street <br>
                NY 535022, USA<br><br>
                <strong>Phone:</strong> +1 5589 55488 55<br>
                <strong>Email:</strong> info@example.com<br>
              </p>
              <div class="social-links d-flex mt-3">
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-twitter"></i></a>
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-facebook"></i></a>
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-instagram"></i></a>
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div><!-- End footer info column-->

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">About us</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Terms of service</a></li>
              <li><a href="#">Privacy policy</a></li>
            </ul>
          </div><!-- End footer links column-->

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><a href="#">Web Design</a></li>
              <li><a href="#">Web Development</a></li>
              <li><a href="#">Product Management</a></li>
              <li><a href="#">Marketing</a></li>
              <li><a href="#">Graphic Design</a></li>
            </ul>
          </div><!-- End footer links column-->

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Hic solutasetp</h4>
            <ul>
              <li><a href="#">Molestiae accusamus iure</a></li>
              <li><a href="#">Excepturi dignissimos</a></li>
              <li><a href="#">Suscipit distinctio</a></li>
              <li><a href="#">Dilecta</a></li>
              <li><a href="#">Sit quas consectetur</a></li>
            </ul>
          </div><!-- End footer links column-->

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Nobis illum</h4>
            <ul>
              <li><a href="#">Ipsam</a></li>
              <li><a href="#">Laudantium dolorum</a></li>
              <li><a href="#">Dinera</a></li>
              <li><a href="#">Trodelas</a></li>
              <li><a href="#">Flexo</a></li>
            </ul>
          </div><!-- End footer links column-->

        </div>
      </div>
    </div>

    <div class="footer-legal text-center position-relative">
      <div class="container">
        <div class="copyright">
          &copy; Copyright <strong><span>Tarun</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/upconstruction-bootstrap-construction-website-template/ -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a
            href="https://themewagon.com">ThemeWagon</a>
        </div>
      </div>
    </div>

  </footer>
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>
  <script>
        function fileValidation() {
            var fileInput =
                document.getElementById('file');
             
            var filePath = fileInput.value;
         
            // Allowing file type
            var allowedExtensions =
                    /(\.jpg|\.jpeg|\.png|\.gif)$/i;
             
            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type');
                fileInput.value = '';
                return false;
            }
            else
            {
             
                // Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(
                            'imagePreview').innerHTML =
                            '<img src="' + e.target.result
                            + '"/>';
                    };
                     
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        }
    </script>
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>