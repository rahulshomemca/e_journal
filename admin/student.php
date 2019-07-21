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
  <title>Student</title>
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
               <a class="nav-link active" href="student.php">Student</a>
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
  <h3>List Of All Students</h3>

   <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal" id="AddStudent">Add Student</button>
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
              
                Name:<input type="text" name="name" id="name" class="form-control"><br>
                Mobile:<input type="text" name="mobile" id="mobile" class="form-control"><br>
                Email:<input type="Email" name="email" id="email" class="form-control"><br> 
                USN:<input type="text" name="usn" id="usn" class="form-control"><br> 
                Department:<input type="text" name="dept" id="dept" class="form-control"><br> 

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

            <!-- Modal Update body -->
      <div class="modal fade" id="update_modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title text-primary">Update Student Details</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
              
                Name:<input type="text" name="name" id="updatename" class="form-control"><br>
                Mobile:<input type="text" name="mobile" id="updatemobile" class="form-control"><br>
                Email:<input type="Email" name="email" id="updateemail" class="form-control"><br> 
                USN:<input type="text" name="usn" id="updateusn" class="form-control"><br> 
                <input type="hidden" id="hidden_student_id">
                <p id="nam_status"></p>
              
            </div>
            <div class="modal-footer">
                <button id="submit" class="btn btn-primary float-right" onclick="updatedetails()">Update</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal Update body -->


      <div class="modal fade" id="view_modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title text-primary">Full Details</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
              
                  
                Name:<input type="text" name="name" id="viewname" class="form-control"><br>
                Mobile:<input type="text" name="mobile" id="viewmobile" class="form-control"><br>
                Email:<input type="Email" name="email" id="viewemail" class="form-control"><br> 
                USN:<input type="text" name="usn" id="viewusn" class="form-control"><br> 
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


</div>

<script type="text/javascript">


  $(document).ready(function(){
    readRecords(); 
  });


 function readRecords(){
  var readRecord = "readRecord";
  $.ajax({
    url: "backend.php",
    type: 'POST',
    data: { readRecord : readRecord},
    success:function(data,status){
      $('#record_table').html(data);
    }

  });

 }


  
   function AddRecord(){

     var name = $('#name').val();
     var email = $('#email').val();
     var mobile = $('#mobile').val();
     var usn = $('#usn').val();
     var dept = $('#dept').val();

     var valid = true;
     
     var nm=/^[A-Z][a-zA-Z0-9_-]{3,19}\s[A-Z][a-zA-Z0-9_-]{0,19}$/;
     var mob=/^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$/;
     var reg=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;
     var un=/^[1-4][A-Z][A-Z][0-9][0-9][A-Z][A-Z][A-Z][0-9][0-9]$/;

     if(name == '' || email == '' || mobile == '' || usn == '' || dept == '')
          {
               $('#name_status' ).html("Please fill all the fields !!");
               $("#name_status").css('color', '#FF0004', 'important');
               return false;
          }

      if(!name.match(nm))
      { 
               $( '#name_status' ).html("Invalid Name !!");
               $("#name_status").css('color', '#FF0004', 'important');
               document.getElementById("name").style.color = "black";
               return false;
      }


      if(!email.match(reg))
      {
               $( '#name_status' ).html("Inavalid Email !!");
               $("#name_status").css('color', '#FF0004', 'important');
               document.getElementById("email").style.color = "black";
               return false;
      }

      if(!mobile.match(mob))
      {
               $( '#name_status' ).html("Invalid Mobile Number !!");
               $("#name_status").css('color', '#FF0004', 'important');
               document.getElementById("mobile").style.color = "black";
               return false;
      }

      if(!usn.match(un))
      {
               $( '#name_status' ).html("Invalid USN !!");
               $("#name_status").css('color', '#FF0004', 'important');
               document.getElementById("mobile").style.color = "black";
               return false;
      }
      
      if(email)
      {
            $.ajax({
                  type: 'post',
                  url: 'backend.php',
                  data: {
                   val_email:email,
                  },
                  success: function (response) {

                         $( '#name_status' ).html(response);
                         if(response=="Registered")  
                         {
                           $("#name_status").css('color', '#0AC02A', 'important');
                              $.ajax({

                                    url: "backend.php",
                                    type: 'POST',
                                    data: {
                                      name : name,
                                      email : email,
                                      mobile : mobile,
                                      usn : usn,
                                      dept : dept
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
        url: 'backend.php',
        type: "POST",
        data: { deleteid : deleteid},
        success: function(data,status){
          location.reload();
          $("#myModal").modal("hide");
        }
    });
  }
 }



function getdetails(updateid){
 $("#hidden_student_id").val(updateid);

    $.ajax({
        url: 'backend.php',
        type: "POST",
        data: { updateid : updateid },
        success: function(data,status){
          var student = JSON.parse(data);
          $('#updatename').val(student.name);
          $('#updateemail').val(student.email);
          $('#updatemobile').val(student.mobile);
          $('#updateusn').val(student.usn);
        }
    });
 
 $("#update_modal").modal("show");
}


function viewdetails(viewid){
 $("#hidden_student_id").val(viewid);

    $.ajax({
        url: 'backend.php',
        type: "POST",
        data: { viewid : viewid },
        success: function(data,status){
          var candidate = JSON.parse(data);
          $('#viewname').val(candidate.name);
          $('#viewemail').val(candidate.email);
          $('#viewmobile').val(candidate.mobile);
          $('#viewusn').val(candidate.usn);
        }
    });
 
 $("#view_modal").modal("show");
}


function updatedetails(){

     var updatename = $('#updatename').val();
     var updateemail = $('#updateemail').val();
     var updatemobile = $('#updatemobile').val();
     var updateusn = $('#updateusn').val();
     var un=/^[1-4][A-Z][A-Z][0-9][0-9][A-Z][A-Z][A-Z][0-9][0-9]$/;

     var hidden_student_id = $('#hidden_student_id').val();

     if(updatename == '' || updateemail == '' || updatemobile == '' || updateusn == '')
          {
               $( '#nam_status' ).html("Please fill all the fields !!");
               $("#nam_status").css('color', '#FF0004', 'important');
               return false;
          }

      var nm=/^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$/;

      if(!updatename.match(nm))
      {
               $( '#nam_status' ).html("Invalid Name !!");
               $("#nam_status").css('color', '#FF0004', 'important');
               document.getElementById("updatename").style.color = "red";
               return false;
      }

      var mob=/^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$/;

      if(!updatemobile.match(mob))
      {
           $( '#nam_status' ).html("Inavalid Mobile Number !!");
           $("#nam_status").css('color', '#FF0004', 'important');
           document.getElementById("updatemobile").style.color = "red";
           return false;
      }

      var reg=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if(!updateemail.match(reg))
      {
           $( '#nam_status' ).html("Inavalid Email ID !!");
           $("#nam_status").css('color', '#FF0004', 'important');
           document.getElementById("updateemail").style.color = "red";
           return false;
      }

      if(!updateusn.match(un))
      {
               $( '#name_status' ).html("Invalid USN !!");
               $("#name_status").css('color', '#FF0004', 'important');
               document.getElementById("mobile").style.color = "black";
               return false;
      }
      
      if(updateemail)
      {
            $.ajax({
                  type: 'post',
                  url: 'backend.php',
                  data: {
                   val_update_email:updateemail,
                   hidden_student_id : hidden_student_id
                  },
                  success: function (response) {

                         $( '#nam_status' ).html(response);
                         if(response=="Updated")  
                         {
                           $("#nam_status").css('color', '#0AC02A', 'important');
                              $.ajax({

                                    url: "backend.php",
                                    type: 'POST',
                                    data: {
                                      updatename : updatename,
                                      updateemail : updateemail,
                                      updatemobile : updatemobile,
                                      updateusn : updateusn,
                                      hidden_student_id : hidden_student_id

                                      },
                                      success:function(data,status){
                                        location.reload();
                                      }
                              });
                         }
                         else
                         {
                           $("#nam_status").css('color', '#FF0004', 'important');
                          return false;
                         }
                  }
            });
      }
}

function reset(student_id){
  var conf = confirm("Are you sure you want to reset this?\nPassword Will be set to default");
  if(conf == true){
    $.ajax({
        url: 'backend.php',
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
