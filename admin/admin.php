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
  <title>Admin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../image/rahul-fav.png" sizes="16x16" type="image/png">
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
              <a class="nav-link" href="acceptedJournals.php">Manage Journals</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="student.php">Student</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="faculty.php">Faculty</a>
            </li>
            <li class="nav-item">
               <a class="nav-link active" href="admin.php">Admin</a>
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
  <h3>List Of All Admin</h3>

   <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal">Add Admin</button>
      </div>
      <br>
      <!-- Table -->
      <div id="record_table">
        
      </div>
      <!-- Table End-->

      <!-- Modal body -->
      <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title text-primary">Enter Student Details</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
              
                Username:<input type="text" name="username" id="username" class="form-control"><br>

                <p id="name_status"></p>
              
            </div>
            <div class="modal-footer">
                <button id="submit" class="btn btn-primary float-right" onclick="AddRecord()">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal End -->

</div>

<script type="text/javascript">


  $(document).ready(function(){
    readRecords(); 
  });


 function readRecords(){
  var readRecord = "readRecord";
  $.ajax({
    url: "backendadmin.php",
    type: 'POST',
    data: { readRecord : readRecord},
    success:function(data,status){
      $('#record_table').html(data);
    }

  });

 }


  
   function AddRecord(){

     var username = $('#username').val();
     
      
      if(username)
      {
            $.ajax({
                  type: 'post',
                  url: 'backendadmin.php',
                  data: {
                   val_username:username,
                  },
                  success: function (response) {

                         $( '#name_status' ).html(response);
                         if(response=="Registered")  
                         {
                           $("#name_status").css('color', '#0AC02A', 'important');
                              $.ajax({

                                    url: "backendadmin.php",
                                    type: 'POST',
                                    data: {
                                      username : username
                                      },
                                      success:function(data,status){
                                        location.reload();
                                      }
                              });
                         }
                         else
                         {
                           $("#name_status").css('color', '#FF0004', 'important');
                          return false;
                         }
                  }
            });
      }
 } 


 
 function deleteStudent(deleteid){
  var conf = confirm("Are you sure you want to delete this record?");
  if(conf == true){
    $.ajax({
        url: 'backendadmin.php',
        type: "POST",
        data: { deleteid : deleteid},
        success: function(data,status){
          location.reload();
          $("#myModal").modal("hide");
        }
    });
  }
 }


function reset(student_id){
  var conf = confirm("Are you sure you want to reset this?\nPassword Will be set to default");
  if(conf == true){
    $.ajax({
        url: 'backendadmin.php',
        type: "POST",
        data: { student_id : student_id},
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
