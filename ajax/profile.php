  <?php
  include "../admin/includes/db.cofig.php";
  include "../admin/includes/essen.php";
   
  //   date_default_timezone_set();

  if(isset($_POST['info_form']))
  {
    $frm_data = filteration($_POST);
    session_start();

    
    $u_exist = select("SELECT * FROM users_cred WHERE phonenum=? AND id_no!=? LIMIT 1",[$frm_data['phonenum'],$_SESSION['uId']],'ss');

    if (mysqli_num_rows($u_exist)!=0){
        echo 'phone_already';
        exit;
    }

    $query = "UPDATE users_cred SET `name`=?,`address`=?,`phonenum`=?,`pincode`=?,`dob`=? WHERE id_no=? LIMIT 1";

    $values = [$frm_data['name'],$frm_data['address'],$frm_data['phonenum'],$frm_data['pincode'],$frm_data['dob'],$_SESSION['uId']];

    if(update($query,$values,'ssssss')){
        $_SESSION['uName'] = $frm_data['name'];
        echo 1;
    }
    else{
        echo 0;
    }

  }

  if(isset($_POST['profile_form']))
  {
    session_start();

    $img = uploadUserImage($_FILES['profile']);

    if ($img == 'inv_img') {
      echo 'inv_img';
      exit;
    }
    elseif ($img == 'upd_failed') {
        echo 'upd_failed';
        exit;
    }
     
    // fetching old image and deleteing
    
    $u_exist = select("SELECT profile FROM users_cred WHERE id_no=? LIMIT 1",[$_SESSION['uId']],"s");

    $u_fetch = mysqli_fetch_assoc($u_exist);

    deleteImage($u_fetch['profile'],USERS_FOLDER);

    $query = "UPDATE users_cred SET 'profile'=? WHERE id_no=? LIMIT 1";

    $values = [$img,$_SESSION['uId']];

    if(update($query,$values,'ss')){
        $_SESSION['uPic'] = $img;
        echo 1;
    }
    else{
        echo 0;
    }

  }

  if(isset($_POST['pass_form']))
  {
    $frm_data = filteration($_POST);
    session_start();

    if($frm_data['new_pass']!=$frm_data['confirm_pass']){
      echo 'mismatch';
      exit;
    }

    $hash_password = password_hash($frm_data['new_pass'],PASSWORD_BCRYPT);

    $query = "UPDATE users_cred SET password=? WHERE id_no=? LIMIT 1";

    $values = [$hash_password,$_SESSION['uId']];

    if(update($query,$values,'ss')){
        echo 1;
    }
    else{
        echo 0;
    }

  }

  ?>
