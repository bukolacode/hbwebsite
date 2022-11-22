<?php
 include "./includes/essen.php";
 include "./includes/db.cofig.php";
 
 adminLogin();


 if (isset($_GET['seen'])) {

    $frm_data = filteration($_GET);

    if ($frm_data['seen']=='all') {
        $q = "UPDATE users_msg SET seen=?";
        $values = [1];
        if (update($q,$values,'i')) {
            alert('success', 'Marked all as read!');
        }else {
            alert('error', 'Operation failed!');
        }
    }else {
        $q = "UPDATE users_msg SET seen=? WHERE id_no=?";
        $values = [1,$frm_data['seen']];
        if (update($q,$values,'ii')) {
            alert('success', 'Marked as read!');
        }else {
            alert('error', 'Operation failed!');
        }
    }

 }
 
 if (isset($_GET['del'])) {

    $frm_data = filteration($_GET);

    if ($frm_data['del']=='all') {
        $q = "DELETE FROM users_msg";
        if (mysqli_query($conn,$q)) {
            alert('success', 'All data deleted!');
        }else {
            alert('error', 'Operation failed!');
        }
    }else {
        $q = "DELETE FROM users_msg WHERE id_no=?";
        $values = [$frm_data['del']];
        if (delete($q,$values,'i')) {
            alert('success', 'Data deleted!');
        }else {
            alert('error', 'Operation failed!');
        }
    }

 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Queries</title>
    <?php include "./includes/links.php";?>
 
</head>
<body class="bg-light">
    
 <?php include "./includes/header.php"; ?>

  <div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
           <h3 class="mb-4">USER QUERIES</h3>
         
          <!-- User Queries section-->

 <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="text-end mb-4">
            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
              <i class="bi bi-check-all"></i> Mark all read
            </a>
            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
              <i class="bi bi-trash"></i> Delete all
            </a>
        </div>
        <div class="table-responsive-md" style="height: 300px; overflow-y:scroll;">
            <table class="table table-hover border">
                <thead class="sticky-top">
                    <tr class="bg-dark text-light">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col" width="10%">Subject</th>
                    <th scope="col" width="20%">Message</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                     $sql = "SELECT * FROM users_msg ORDER BY id_no DESC";
                     $data = mysqli_query($conn,$sql);
                     $i =1;
                     while ($row = mysqli_fetch_assoc($data)) 
                     {
                        $date = date('d-m-y',strtotime($row['datentime']));
                        $seen = '';
                         if ($row['seen']!=1){
                            $seen = "<a href='?seen=$row[id_no]' class='btn btn-sm rounded-pill btn-primary'>Mark as read</a> <br>";
                         }
                         $seen.= "<a href='?del=$row[id_no]' class='btn btn-sm rounded-pill btn-danger mt-2'>Delete</a>";
                        echo <<<query
                           <tr>
                            <td>$i</td>
                            <td>$row[name]</td>
                            <td>$row[email]</td>
                            <td>$row[subject]</td>
                            <td>$row[message]</td>
                            <td>$date</td>
                            <td>$seen</td>
                           </tr>
                        query;
                        $i++;
                    }
                   ?>
                </tbody>
            </table>
        </div>
    </div>
 </div>

        </div>
    </div>
  </div>

<?php include "./includes/script.php"; ?>

</body>
</html>
