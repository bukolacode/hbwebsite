
<?php
 include "./admin/includes/essen.php";

 session_start();
 session_destroy();
 header("location:index.php");
?>
