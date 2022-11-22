<?php
    include "../includes/db.cofig.php";
    include "../includes/essen.php";
    adminLogin();

if(isset($_POST['booking_analytics']))
{
  $frm_data = filteration($_POST);

  $cond = "";

  if($frm_data['period']==1){
    $cond = "WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
  }
  else if($frm_data['period']==2){
    $cond = "WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
  }
  else if($frm_data['period']==3){
    $cond = "WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
  }

  
  $result = mysqli_fetch_assoc(mysqli_query($conn,"SELECT 
   COUNT(CASE WHEN booking_status!='pending' AND booking_status!='payment failed' THEN 1 END) AS total_bookings,
   SUM(CASE WHEN booking_status!='pending' AND booking_status!='payment failed' THEN trans_amt END) AS total_amt,

   COUNT(CASE WHEN booking_status='booked' AND arrival=1 THEN 1 END) AS active_bookings,
   SUM(CASE WHEN booking_status='booked' AND arrival=1 THEN trans_amt END) AS active_amt,

   COUNT(CASE WHEN booking_status='cancelled' AND refund=1 THEN 1 END) AS cancelled_bookings,
   SUM(CASE WHEN booking_status='cancelled' AND refund=1 THEN trans_amt END) AS cancelled_amt FROM booking_order $cond"));

   $output = json_encode($result);

   echo $output;

}

if(isset($_POST['user_analytics']))
{
  $frm_data = filteration($_POST);

  $cond = "";

  if($frm_data['period']==1){
    $cond = "WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
  }
  else if($frm_data['period']==2){
    $cond = "WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
  }
  else if($frm_data['period']==3){
    $cond = "WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
  }

  $total_queries = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id_no) AS 'count' FROM users_msg $cond"));

  $total_reviews = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id_no) AS 'count' FROM rating_review $cond"));

  $total_new_reg = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id_no) AS 'count' FROM users_cred $cond"));

  $output = ['total_queries' => $total_queries['count'],
   'total_reviews' => $total_reviews['count'], 'total_new_reg' => $total_new_reg['count']
  ];
  $output = json_encode($output);

  echo $output;

}



?>


