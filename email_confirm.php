<?php

include "./admin/includes/db.cofig.php";
include "./admin/includes/essen.php";

if(isset($_GET['email_confirmation']))
{
    $data = filteration($_GET);

    $query = select("SELECT * FROM users_cred WHERE email=? AND token=? LIMIT 1",[$data['email'],$data['token']],'ss');

    if (mysqli_num_rows($query)==1){
        $fetch = mysqli_fetch_assoc($query);

        if($fetch['is_verified']==1){
            echo "<script>alert('Email already verified!')</script>";
            header("location: index.php");
        }
        else{
            $upd = update("UPDATE users_cred SET is_verified=? WHERE id_no=?",[1,$fetch['id_no']],'ii');
            if($upd){
                echo "<script>alert('Email Verification Successful!')</script>";
            }
            else{
               echo "<script>alert('Email Verification Failed!')</script>";
            }
        }
        header("location: index.php");
    }
    else{
        echo "<script>alert('Invalid Link!')</script>";
        header("location: index.php");
    }
}

?>
