<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
    <?php require "./inc/links.php";?>
    <title><?php echo $settings_r['site_title'] ?> - ABOUT</title>
    <style>
        .box{
           border-top-color: var(--teal) !important;
        }
    </style>
</head>
<body class="bg-light">
<?php require "./inc/header.php"; ?>
  
 <div class="my-5 px-4">
   <h2 class="text-center fw-bold h-font">ABOUT US</h2>
   <div class="h-line bg-dark"></div>
   <p class="text-center mt-3">
     Lorem ipsum, dolor sit amet consectetur adipisicing elit.
     Suscipit deleniti commodi<br> dolores accusamus maiores quasi 
     debitis voluptates porro. Ipsam, error!
   </p>
 </div>
 
 <div class="container">
    <div class="row justify-content-between align-items-center">
        <div class="col-lg-6 col-md-6 mb-4 order-lg-1 order-md-1 order-2">
            <h3 class="mb-3">Lorem, ipsum dolor.</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Atque magnam iure distinctio dolorum nam ut tenetur.
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Atque magnam iure distinctio dolorum nam ut tenetur.
            </p>
        </div>
        <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
            <img src="images/about/profile 2.jpg" class="w-100">
        </div>
    </div>
 </div>

 <div class="container mt-5">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class=" bg-white rounded shadow p-4 border-top border-4 text-center box">
               <img src="images/about/hotel.svg" width="70px">
               <h4 class="mt-3">100+ ROOMS</h4>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class=" bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/customers.svg" width="50px">
                <h4 class="mt-3">200+ CUSTOMERS</h4>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class=" bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/rating.svg" width="70px">
                <h4 class="mt-3">150+ REVIEWS</h4>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class=" bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/staff.svg" width="70px">
                <h4 class="mt-3">200+ STAFFS</h4>
            </div>
        </div>
    </div>
 </div>


 <h3 class="text-center h-font fw-bold fs-3 my-5">MANAGENENT TEAM</h3>
   <div class="container px-4">
         <!-- Swiper -->
    <div class="swiper swiper-team">
      <div class="swiper-wrapper mb-5">
        <?php
          $about_r = selectAll('team_details');
          $path = ABOUT_IMG_PATH;
          while ($row = mysqli_fetch_assoc($about_r)) {
            echo <<<data
                <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                    <img src="$path$row[picture]" class="w-100">
                    <h5 class="mt-2">$row[name]</h5>
                </div>
            data;
          }
        ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
   </div>
   <!-- footer -->
<?php require "./inc/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
 <!-- Initialize Swiper -->
 <script>
      var swiper = new Swiper(".swiper-team", {
        spaceBetween: 40,
        pagination: {
          el: ".swiper-pagination",
        },
     breakpoints:{
        320:{
            slidesPerView: 1,
        },
        640:{
            slidesPerView: 1,
        },
        786:{
            slidesPerView: 2,
        },
        1024:{
        slidesPerView: 3,
            }
       }
      });
    </script>
</body>
</html>
