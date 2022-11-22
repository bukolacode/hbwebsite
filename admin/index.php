<?php
 include "./includes/essen.php";
 include "./includes/db.cofig.php";

 session_start();
    if ((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)) {
        header("location: dashboard.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "./includes/links.php"; ?>
    <title>Admin Login Panel</title>
    <style>
        div.login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
        .custom-alert{
            position: fixed;
            top: 25px;
            right: 25px;
        }
        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
        }
    </style>
</head>
<body class="bg-light">
    
<div class="login-form text-center rounded bg-white shadow overflow-hidden">
  <form method="POST">
    <h4 class="bg-dark text-white py-3">Admin Login Panel</h4>
    <div class="p-4">
        <div class="mb-3">
            <input type="text" name="admin_name" class="form-control shadow-none text-center" placeholder="Admin Name" required>
        </div>
        <div class="mb-4">
            <input type="password" name="admin_pass" class="form-control shadow-none text-center" placeholder="Password" required>
        </div>
        <button type="submit" name="LOGIN" class="btn text-white custom-bg shadow-none">LOGIN</button>
    </div>
  </form>
</div>

<?php
    if (isset($_POST['LOGIN'])) {
        $frm_data = filteration($_POST);
        
       $query = "SELECT * FROM admin_cred WHERE admin_name =? AND admin_pass =?";
       $values = [$frm_data['admin_name'], $frm_data['admin_pass']];
      
       $res = select($query,$values,"ss");
       if ($res->num_rows==1) {
         $row = mysqli_fetch_assoc($res);;
         $_SESSION['adminLogin'] = true;
         $_SESSION['adminId'] = $row['id_no'];
         header("location: dashboard.php");
       }
       else {
          alert('error','Login failed - Invalid Credentials');
       }
    }

?>

<?php include "./includes/script.php"; ?>
</body>
</html>
