<?php
 include "./includes/essen.php";
 include "./includes/db.cofig.php";
 adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <?php include "./includes/links.php";?>
</head>
<body class="bg-light">
    
 <?php 
  include "./includes/header.php";

  $is_shutdown = mysqli_fetch_assoc(mysqli_query($conn,"SELECT shutdown FROM settings"));

  $current_booking = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(CASE WHEN booking_status='booked' AND arrival=0 THEN 1 END) AS new_bookings,
   COUNT(CASE WHEN booking_status='cancelled' AND refund=0 THEN 1 END) AS refund_bookings FROM booking_order"));

  $unread_queries = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id_no) AS counts FROM users_msg WHERE seen=0"));

  $unread_review = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id_no) AS counts FROM rating_review WHERE seen=0"));

  $current_user = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id_no) AS total, COUNT(CASE WHEN status=1 THEN 1 END) AS active,
   COUNT(CASE WHEN status=0 THEN 1 END) AS inactive,  COUNT(CASE WHEN is_verified=0 THEN 1 END) AS unverified FROM users_cred"));
 ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
      <div class="col-lg-10 ms-auto p-4 overflow-hidden">

        <div class="d-flex align-items-center justify-content-between mb-4">
          <h3>DASHBOARD</h3>
          <?php
           if($is_shutdown['shutdown']){
            echo <<<data
             <h6 class="badge bg-danger py-2 px-3 rounded">Shut Mode Is Active!</h6>
            data;
           }
          ?>
        </div>

        <div class="row mb-4">
            <div class="col-3 mb-4">
              <a href="new_bookings.php" class="text-decoration-none">
                <div class="card text-center text-success p-3">
                  <h6>New Bookings</h6>
                  <h1 class="mb-0 mt-2"><?php echo $current_booking['new_bookings']?></h1>
                </div>
              </a>
            </div>

            <div class="col-3 mb-4">
              <a href="refund_bookings.php" class="text-decoration-none">
                <div class="card text-center text-warning p-3">
                  <h6>Refund Bookings</h6>
                  <h1 class="mb-0 mt-2"><?php echo $current_booking['refund_bookings']?></h1>
                </div>
              </a>
            </div>

            <div class="col-3 mb-4">
              <a href="users_queries.php" class="text-decoration-none">
                <div class="card text-center text-info p-3">
                  <h6>Users Queries</h6>
                  <h1 class="mb-0 mt-2"><?php echo $unread_queries['counts'] ?></h1>
                </div>
              </a>
            </div>

            <div class="col-3 mb-4">
              <a href="rate_review.php" class="text-decoration-none">
                <div class="card text-center text-warning p-3">
                  <h6>Rating & Reviews</h6>
                  <h1 class="mb-0 mt-2"><?php echo $unread_review['counts'] ?></h1>
                </div>
              </a>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
          <h3>Booking Analytics</h3>
          <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
            <option value="1">Past 30days</option>
            <option value="2">Past 90days</option>
            <option value="3">Past 1year</option>
            <option value="4">All time</option>
          </select>
        </div>

        <div class="row mb-3">
            <div class="col-3 mb-4">
                <div class="card text-center text-primary p-3">
                  <h6>Total Bookings</h6>
                  <h1 class="mb-0 mt-2" id="total_bookings">0</h1>
                  <h4 class="mb-0 mt-2" id="total_amt"> ₦0</h4>
                </div>
            </div>

            <div class="col-3 mb-4">
                <div class="card text-center text-success p-3">
                  <h6>Active Bookings</h6>
                  <h1 class="mb-0 mt-2" id="active_bookings">0</h1>
                  <h4 class="mb-0 mt-2" id="active_amt">₦0</h4>
                </div>
            </div>

            <div class="col-3 mb-4">
                <div class="card text-center text-danger p-3">
                  <h6>Cancelled Bookings</h6>
                  <h1 class="mb-0 mt-2" id="cancelled_bookings">0</h1>
                  <h4 class="mb-0 mt-2" id="cancelled_amt">₦0</h4>
                </div>
              </a>
            </div>

        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
          <h3>Users, Queries, Reviews Analytics</h3>
          <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
            <option value="1">Past 30days</option>
            <option value="2">Past 90days</option>
            <option value="3">Past 1year</option>
            <option value="4">All time</option>
          </select>
        </div>

        <div class="row mb-3">
            <div class="col-3 mb-4">
                <div class="card text-center text-success p-3">
                  <h6>New Registration</h6>
                  <h1 class="mb-0 mt-2" id="total_new_reg">0</h1>
                </div>
            </div>

            <div class="col-3 mb-4">
                <div class="card text-center text-primary p-3">
                  <h6>Queries</h6>
                  <h1 class="mb-0 mt-2" id="total_queries">0</h1>
                </div>
            </div>

            <div class="col-3 mb-4">
                <div class="card text-center text-primary p-3">
                  <h6>Reviews</h6>
                  <h1 class="mb-0 mt-2" id="total_reviews">0</h1>
                </div>
              </a>
            </div>

        </div>

        <h5>Users</h5>
        <div class="row mb-3">
            <div class="col-3 mb-4">
                <div class="card text-center text-info p-3">
                  <h6>Total</h6>
                  <h1 class="mb-0 mt-2"><?php echo $current_user['total'] ?></h1>
                </div>
            </div>

            <div class="col-3 mb-4">
                <div class="card text-center text-success p-3">
                  <h6>Active</h6>
                  <h1 class="mb-0 mt-2"><?php $current_user['active'] ?></h1>
                </div>
            </div>

            <div class="col-3 mb-4">
                <div class="card text-center text-warning p-3">
                  <h6>Inactive Users</h6>
                  <h1 class="mb-0 mt-2"><?php echo $current_user['inactive'] ?></h1>
                </div>
              </a>
            </div>

            <div class="col-3 mb-4">
                <div class="card text-center text-danger p-3">
                  <h6>Unverified Users</h6>
                  <h1 class="mb-0 mt-2"><?php echo $current_user['unverified'] ?></h1>
                </div>
              </a>
            </div>

        </div>

      </div>
    </div>
  </div>

<?php include "./includes/script.php"; ?>
<script src="scripts/dashboard.js"></script>
</body>
</html>
