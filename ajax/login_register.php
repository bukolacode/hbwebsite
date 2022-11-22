<?php
  
  include "../admin/includes/db.cofig.php";
  include "../admin/includes/essen.php";
  // include "../inc/sendgrid/sendgrid-php.php";
  include "../vendor/autoload.php";

  function sendMail($uemail,$name,$token){
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom(SENDGRID_EMAIL,SENDGRID_NAME);
    $email->setSubject("Account verification Link");

    $email->addTo($uemail,$name);

    $email->addContent(
        "text/html",
        "Click the link to confirm your email: <br>
        <a href='".SITE_URL."email_confirm.php?email_confirmation&email=$uemail&token=$token"."'>
          CLICK ME
        </a>
        "
    );

    $sendgrid = new \SendGrid(SENDGRID_API_KEY);

        try{
        $sendgrid->send($email);
        return 1;
       }                               

       catch (Exception $e) {
        return 0;
       }
  }


  if (isset($_POST['register'])){

    $data = filteration($_POST);

    // matches password and confirm password field
    
    if ($data['pass']!= $data['cpass']) {
        echo "Pass_mismatch";
        exit;
    }

    // user exist or not

    $u_exist = select("SELECT * FROM users_cred WHERE email=? OR phonenum=? LIMIT 1",[$data['email'],$data['phonenum']],'ss');

    if (mysqli_num_rows($u_exist)!=0){
        $fetch = mysqli_fetch_assoc($u_exist);
        echo ($fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    // upload user image to server

    $img = uploadUserImage($_FILES['profile']);

    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    }
    elseif ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }

    //  send confirmation links to user's email
    $token = bin2hex(random_bytes(16));

   if (!sendMail($data['email'],$data['name'],$token)){
    echo 'mail_failed';
    exit;
   }

    $hash_password = password_hash($data['pass'],PASSWORD_BCRYPT);

    $query = "INSERT INTO users_cred (`name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `token`)
     VALUES (?,?,?,?,?,?,?,?,?)";

    $values = [$data['name'],$data['email'],$data['address'],$data['phonenum'],$data['pincode'],$data['dob'],$img,$hash_password,$token];

    if(insert($query,$values,'sssssssss')){
      echo 1;
    }
    else {
      echo 'ins_failed';
    }

  }

  if (isset($_POST['login'])){
    
    $data = filteration($_POST);

     // user exist or not

     $u_exist = select("SELECT * FROM users_cred WHERE email=? OR phonenum=? LIMIT 1",[$data['email_mob'],$data['email_mob']],'ss');

     if (mysqli_num_rows($u_exist)==0){
        echo 'inv_email_mob';
     }
     else{
      $u_fetch = mysqli_fetch_assoc($u_exist);
      if($u_fetch['is_verified']==0){
        echo 'not_verified';
      }
      else if($u_fetch['status']==0){
        echo 'inactive';
      }
      else{
        if(!password_verify($data['pass'],$u_fetch['password'])){
           echo 'invalid_pass';
        }
        else{
          session_start();
          $_SESSION['login'] = true;
          $_SESSION['uId'] = $u_fetch['id_no'];
          $_SESSION['uName'] = $u_fetch['name'];
          $_SESSION['uPic'] = $u_fetch['profile'];
          $_SESSION['uPhone'] = $u_fetch['phonenum'];
          echo 1;
        }
      }
    }

  }

  // if (isset($_POST['forgot_pass'])){

  //   $data = filteration($_POST);

  //   $u_exist = select("SELECT * FROM users_cred WHERE email=? LIMIT 1",[$data['email_mob']],"s");

  //   if (mysqli_num_rows($u_exist)==0){
  //      echo 'inv_email';
  //   }
  //   $u_fetch = mysqli_fetch_assoc($u_exist);
  //     if($u_fetch['is_verified']==0){
  //       echo 'not_verified';
  //     }
  //     else if($u_fetch['status']==0){
  //       echo 'inactive';
  //     }
  // }

?>

<!-- oluwabukologunneye@gmail.com -->
