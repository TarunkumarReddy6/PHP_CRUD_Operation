<?php
session_start();
include "db.php";

if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
}



$countQuery = "SELECT COUNT(*) as total FROM register";
$countResult = $conn->query($countQuery);
$countRow = $countResult->fetch_assoc();
$totalRows = $countRow['total'];


$recordsPerPage = 1;
$totalPages = ceil($totalRows / $recordsPerPage);


if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}


$offset = ($currentPage - 1) * $recordsPerPage;


$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchQuery = "SELECT * FROM register WHERE name LIKE '%$search%' OR address LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' LIMIT $offset, $recordsPerPage";
$result = $conn->query($searchQuery);


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
  <link href="assets/img/favicon.png" rel="icon"> -->
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

  <!-- =======================================================
  * Template Name: UpConstruction - v1.3.0
  * Template URL: https://bootstrapmade.com/upconstruction-bootstrap-construction-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

</head>

<body>
    <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>MeConstruction<span>.</span></h1>
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

      <form action="user_data.php">
      <input style="border-radius:7px; min-height:48px; min-width:480px;"  type="text" placeholder="Search.." name="search">
      <button style="border-radius:7px; min-height:48px; min-width:48px;" type="submit"><i class="fa fa-search"></i></button>
    </form>


            
      </div>

    </div><!-- End Breadcrumbs -->
    <div align="center">
        <h2>User Details</h2>
         <table style="width: 100%;display: inline; justify-content: center; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Name</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Address</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Email</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Phone</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Image</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($user = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;color: black"><?php echo $user['name']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;color: black"><?php echo $user['address']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;color: black"><?php echo $user['email']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;color: black"><?php echo $user['phone']; ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;color: black"><img width="150px" height="auto" src='<?php echo $user['user_image']; ?>'></td>
                            <td style="padding: 10px; border: 1px solid #ddd;color: black"><a class="btn btn-danger" href="edit_form.php?id=<?php echo $user['id']; ?>">Edit</a>&nbsp;<a class="btn btn-danger" href="delete.php?id=<?php echo $user['id']; ?>">Delete</a></td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center; padding: 10px; border: 1px solid #ddd;color: black;'>No records found</td></tr>";
                }
                ?>
                <td>
                <ul style="margin-left:20px;"  class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<li class='page-item";
                if ($i == $currentPage) {
                    echo " active";
                }
                echo "'><a class='page-link' href='user_data.php?page=$i'>$i</a></li>";
            }
            ?>
        </ul>

                </td>
            </tbody>
        </table>

      
        
    </div>
    </main><!-- End #main -->

  
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
            