<?php include 'dbcon.php';?>
<?php
session_start();

  if(!isset($_SESSION['email']))
  {
    header('location:index.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Journal</title>
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
              <a class="nav-link " href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="add.php">Add Journal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="settings.php">Change Password</a>
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
      <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal">Add Journal</button>
      </div>
      <br>
      

      <!-- Modal body -->
      <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">
              <h4 class="modal-title text-primary">Enter Journal Details</h4>
              <br><i>Note : Format Should be only PDF</i>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
              
                <form action="add.php" method="POST" enctype="multipart/form-data">

                  Title:<input type="text" name="title" id="title" class="form-control"><br>
                  Catagory:<input type="text" name="catagory" id="catagory" class="form-control"><br>
                  Choose File : <input type="file" name="file" id = "file">
                  
                  <input type="submit" name="submit" class="btn btn-primary btn-block"" value="Upload Journal">

                </form>
              
            </div>
          </div>
        </div>
      </div>
</div>
<?php 
  if(isset($_POST['submit']))
  {
    date_default_timezone_set("Asia/Kolkata");
    $email = $_SESSION['email'];
    $qry = "SELECT * FROM `faculty` WHERE `email`='$email';";
    $res = $mysqli->query($qry) or die(error.__LINE__);
    $row = mysqli_fetch_assoc($res);

    $author_id = $row['id'];
    $name = $row['name'];
    $author = 'Faculty';
    $title = $_POST['title'];
    $catagory = $_POST['catagory'];
    $date = date("d-m-Y");
    $status = 'Pending';

    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.' , $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf', 'PDF');

    if(in_array($fileActualExt, $allowed))
    {
      if($fileError === 0){
        if($fileSize < 100000000){
          $fileNameNew = uniqid('', true).".".$fileActualExt;
          $fileDestination = '../uploads/'.$fileNameNew;
          move_uploaded_file($fileTmpName, $fileDestination);

          $query = "INSERT INTO `journal`(`author_id`, `author`, `Name` , `title`, `categories`, `date`, `file_name`, `status`) VALUES ('$author_id','$author','$name','$title','$catagory','$date','$fileDestination','$status')";

          $result = $mysqli->query($query) or die(error.__LINE__);
          if($result)
          {
            ?>
                <br>
                  <div class="container">
                    <div class="alert alert-success">
                    <strong>Success!</strong> Journal Uploaded!!
                    <meta http-equiv="refresh" content="1; URL='add.php'" />
                    </div>
                  </div>
            <?php
          }
          else
          {
            ?>
                <br>
                  <div class="container">
                    <div class="alert alert-danger">
                    <strong>Error!</strong> Journal Not Uploaded!!
                    </div>
                  </div>
            <?php
          }
        }
        else
        {
          ?>
                <br>
                  <div class="container">
                    <div class="alert alert-danger">
                    <strong>Error!</strong> File Size Too Large!!
                    </div>
                  </div>
          <?php
        }
      }      
    }
    else
    {
      ?>
          <br>
            <div class="container">
              <div class="alert alert-danger">
              <strong>Failed!</strong> You cannot Upload File of this type!!
              </div>
            </div>
      <?php
    }
  }
  
?>

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

 function deleteJournal(deleteid){
  var conf = confirm("Are you sure you want to delete this Journal?");
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


 </script>
 <div class="container">
      <div id="record_table"></div>
 </div>

</body>
</html>
