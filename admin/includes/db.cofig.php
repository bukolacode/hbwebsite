<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db_name = 'hotel_booking';

$conn = mysqli_connect($hostname,$username,$password,$db_name);
if (!$conn) {
    die("cannot connect to database".mysqli_connect_error());
}

function filteration($data){
    foreach ($data as $key => $values) {
        $values = trim($values);
        $values =  stripslashes($values);
        $values =  strip_tags($values);
        $values =  htmlspecialchars($values);
        $data[$key] = $values;
    }
    return $data;
}

function selectAll($table){
   $conn = $GLOBALS['conn'];
   $res = mysqli_query($conn, "SELECT * FROM $table");
   return $res;
}

function select($sql,$values,$datatypes){
     $conn = $GLOBALS['conn'];
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt,$datatypes,...$values);
        if (mysqli_stmt_execute($stmt)) {
           $res = mysqli_stmt_get_result($stmt);
           mysqli_stmt_close($stmt);
           return $res;
        }
        else{
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Select");
        }
    }
    else {
        die("Query cannot be prepared - Select");
    }
}

function update($sql,$values,$datatypes){
    $conn = $GLOBALS['conn'];
   if ($stmt = mysqli_prepare($conn, $sql)) {
       mysqli_stmt_bind_param($stmt,$datatypes,...$values);
       if (mysqli_stmt_execute($stmt)) {
          $res = mysqli_stmt_affected_rows($stmt);
          mysqli_stmt_close($stmt);
          return $res;
       }
       else{
           mysqli_stmt_close($stmt);
           die("Query cannot be executed -Update");
       }
   }
   else {
       die("Query cannot be prepared -Update");
   }
}

function insert($sql,$values,$datatypes){
    $conn = $GLOBALS['conn'];
   if ($stmt = mysqli_prepare($conn, $sql)) {
       mysqli_stmt_bind_param($stmt,$datatypes,...$values);
       if (mysqli_stmt_execute($stmt)) {
          $res = mysqli_stmt_affected_rows($stmt);
          mysqli_stmt_close($stmt);
          return $res;
       }
       else{
           mysqli_stmt_close($stmt);
           die("Query cannot be executed - Insert");
       }
   }
   else {
       die("Query cannot be prepared - Insert");
   }
}

function delete($sql,$values,$datatypes){
    $conn = $GLOBALS['conn'];
   if ($stmt = mysqli_prepare($conn, $sql)) {
       mysqli_stmt_bind_param($stmt,$datatypes,...$values);
       if (mysqli_stmt_execute($stmt)) {
          $res = mysqli_stmt_affected_rows($stmt);
          mysqli_stmt_close($stmt);
          return $res;
       }
       else{
           mysqli_stmt_close($stmt);
           die("Query cannot be executed - Delete");
       }
   }
   else {
       die("Query cannot be prepared - Delete");
   }
}


?>
