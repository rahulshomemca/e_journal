<?php
include ('dbcon.php');
session_start();
if(isset($_SESSION['uname']))
{
  header('location:dashboard.php');
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

<br>
<br>
<br>
<div class="container testimonial-con">

        <div class="col-lg-6 col-md-6 col-sm-10 col-10 d-block m-auto">
          <div class="card shadow p-4 mb-4 bg-white">
            <h2 class="text-center text-info">Admin Login</h2><br>

              <form action="index.php" method="POST">

                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username"><br>
                <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Enter Password"><br>
                <input type="submit" name="submit" id = "submit" value="Login" class="btn btn-info btn-block">

              </form>
          </div>
        </div>
</div>
<?php

  if(isset($_POST['submit']))
  {
    $username = $_POST['username'];
    $pass = $_POST['pwd'];

      $qry = "SELECT * FROM `admin` WHERE `username`='$username';";
      $res = $mysqli->query($qry) or die(error.__LINE__);
      $cnt = mysqli_num_rows($res);
      if($cnt == 0)
      {
        ?>  <br>
          <div class="container">
            <div class="alert alert-danger">
            <strong>Failed!</strong> Account doesn't exist!!
            </div>
          </div>
        <?php
      }
      else
      {

        $row = mysqli_fetch_assoc($res);
        if(md5($pass) == $row['password'])
        {
          
          $uname = $row['username'];
          $_SESSION['uname'] = $uname;
          ?>
              <meta http-equiv="refresh" content="0; URL='dashboard.php'" />
          <?php
          
        }
        else
        {
          ?>  <br>
            <div class="container">
              <div class="alert alert-danger">
              <strong>Failed!</strong> Records doesn't match!!
              </div>
            </div>
          <?php
        }
      }
  }

?>
</body>
</html>