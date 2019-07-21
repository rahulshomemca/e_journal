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
  <title>Settings</title>
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
              <a class="nav-link" href="add.php">Add Journal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="settings.php">Change Password</a>
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

        <div class="col-lg-6 col-md-6 col-sm-10 col-10 d-block m-auto">
          <div class="card shadow p-4 mb-4 bg-white">
              <form action="settings.php" method="POST">
                Current Password:<input type="password" name="cpass" class="form-control"><br>
                New Password:<input type="password" name="npass" class="form-control"><br>
                Confirm New Password:<input type="password" name="cnpass" class="form-control"><br> 
                <input type="submit" name="submit" value="Update" class = "btn btn-primary">
              </form>
          </div>
        </div>

        <?php

            if(isset($_POST['submit']))
            {

              $ses_email = $_SESSION['email'];
              $qry = "SELECT * FROM student WHERE email = '$ses_email';";
              $res = $mysqli->query($qry) or die(error.__LINE__);
              $row = mysqli_fetch_assoc($res);

              $student_pass = $row['password'];


              $current_pass = $_POST['cpass'];
              $nwpass = $_POST['npass'];
              $cnwpass = $_POST['cnpass'];

              if($nwpass == '' || $cnwpass == '' || $current_pass == ''){
                ?>
                  <br>
                  <div class="container">
                    <div class="alert alert-danger">
                    <strong>Error!</strong> Fields Cannot be Blank !!
                    <meta http-equiv="refresh" content="1; URL='settings.php'" />
                    </div>
                  </div>
                <?php
              }
              else{

                if($nwpass != $cnwpass){
                   ?>
                      <br>
                      <div class="container">
                        <div class="alert alert-danger">
                        <strong>Error!</strong> Both Password Should Match!!
                        <meta http-equiv="refresh" content="1; URL='settings.php'" />
                        </div>
                      </div>
                  <?php
                }
                else
                {
                  if(md5($current_pass) == $student_pass)
                  {

                    $upass = md5($nwpass);

                    $qry = "UPDATE `student` SET `password` = '$upass' WHERE `email` = '$ses_email';";
                    $result = $mysqli->query($qry) or die(error.__LINE__);
                    if($result == true)
                    {
                      ?>
                        <br>
                        <div class="container">
                          <div class="alert alert-success">
                          <strong>Sucsess!!</strong> Password Sucessfully Changed !!
                          <meta http-equiv="refresh" content="1; URL='settings.php'" />
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
                          <strong>Error!!</strong> Current Password Doesn't Match !!
                          <meta http-equiv="refresh" content="1; URL='settings.php'" />
                          </div>
                        </div>
                      <?php
                  }
                }
              }


            }

        ?>
</div>

</body>
</html>
