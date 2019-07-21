<?php include 'dbcon.php';?>
<?php
session_start();

  if(!isset($_SESSION['uname']))
  {
    header('location:index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Dashboard</title>
  <meta charset="utf-8">
  <link rel="icon" href="../image/rahul-fav.png" sizes="16x16" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>


<nav class="navbar navbar-expand-md mymenu navbar-dark bg-dark">
      <div class="container-fluid">
        <a href="index.php" class="navbar-brand">Welcome to <strong>E-Journal</strong></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mymenu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center" id="mymenu">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pending.php">Pending Journals</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="acceptedJournals.php">Manage Journals</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="student.php">Student</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="faculty.php">Faculty</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="admin.php">Admin</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="settings.php">Change Password</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
</nav>

<br>
  
<div class="container">
   <!-- Table -->
      <div id="record_table_pending">
        
      </div>
      <!-- Table End-->
</div>

<script type="text/javascript">


  $(document).ready(function(){
    readRecordsAccepted(); 
  });


 function readRecordsAccepted(){
  var readRecordsAccepted = "readRecordsAccepted";
  $.ajax({
    url: "backend.php",
    type: 'POST',
    data: { readRecordsAccepted : readRecordsAccepted},
    success:function(data,status){
      $('#record_table_pending').html(data);
    }

  });

 }

  function deleteJournal(delete_jor_id){
  var conf = confirm("Are you sure you want to delete this record?");
  if(conf == true){
    $.ajax({
        url: 'backend.php',
        type: "POST",
        data: { delete_jor_id : delete_jor_id},
        success: function(data,status){
          location.reload();
          $("#myModal").modal("hide");
        }
    });
  }
 }

 function hide(jor_hide_id){
  var conf = confirm("Are you sure you want to hide this record?\nThis will be moved to pending Journals");
  if(conf == true){
    $.ajax({
        url: 'backend.php',
        type: "POST",
        data: { jor_hide_id : jor_hide_id},
        success: function(data,status){
          location.reload();
          $("#myModal").modal("hide");
        }
    });
  }
 }


</script>
</body>
</html>
