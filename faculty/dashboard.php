<?php include 'dbcon.php';?>
<?php
session_start();

  if(!isset($_SESSION['email']))
  {
    header('location:index.php');
  }

  $ses_email = $_SESSION['email'];
  $qry = "SELECT * FROM faculty WHERE email = '$ses_email';";
  $res = $mysqli->query($qry) or die(error.__LINE__);
  $row = mysqli_fetch_assoc($res);

  $author_id = $row['id'];

  $displayqry = "SELECT * FROM journal WHERE author_id <> '$author_id' AND status = 'Published' ORDER BY id DESC";
  $result = $mysqli->query($displayqry) or die(error.__LINE__);

  $cnt = mysqli_num_rows($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <link rel="icon" href="../image/rahul-fav.png" sizes="16x16" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
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
              <a class="nav-link active" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="add.php">Add Journal</a>
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
  <h5>Welcome , <strong><?php echo $row['name']?></strong></h5><br>
<p>Type something in the input field to search the table for Names, Published By, Title, Catogory or Date:</p>
  <input class="form-control" id="myInput" type="text" placeholder="Search..">
  <br>
  <table class="table table-bordered table-striped">
            <thead>
              <th class="text-center">SL.NO</th>
              <th class="text-center">Name</th>
              <th class="text-center">Published By</th>
              <th class="text-center">Title</th>
              <th class="text-center">Catagory</th>
              <th class="text-center">Date</th>
              <th class="text-center">View</th>
            </thead>
    <tbody id="myTable">
    <?php
      for($i=0;$i<$cnt;$i=$i+1)
      {
        $row = $result->fetch_assoc();
        ?>
      <tr>
        <td class="text-center"><?php echo $i+1 ?></td>
        <td class="text-center"><?php echo $row['Name'] ?></td>
        <td class="text-center"><?php echo $row['author'] ?></td>
        <td class="text-center"><?php echo $row['title'] ?></td>
        <td class="text-center"><?php echo $row['categories'] ?></td>
        <td class="text-center"><?php echo $row['date'] ?></td>
        <td class="text-center"><a href="<?php echo $row['file_name'] ?>" target="_blank"><i class="fas fa-file-download"></i></a></td>


      </tr>
      <?php
        }
        ?>
    </tbody>
  </table>
</div>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</body>
</html>
