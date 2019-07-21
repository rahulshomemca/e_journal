<?php include 'dbcon.php';?>
<?php
session_start();

  if(!isset($_SESSION['uname']))
  {
    header('location:index.php');
  }
?>
<?php
	
	$conn = mysqli_connect('localhost','root');
	mysqli_select_db($conn,'e_journal');

	extract($_POST);

	//show in table
	if(isset($_POST['readRecord'])){

		$displayqry = "select * from admin order by id DESC";
		$result = mysqli_query($conn,$displayqry);
		if(mysqli_num_rows($result) > 0)
		{

			$data = '<table class="table table-bordered">
						<thead>
							<th class="text-center">SL.NO</th>
							<th class="text-center">Username</th>
							<th class="text-center">Delete | Reset</th>
						</thead>';
			
				$sl = 1;

				while($row = mysqli_fetch_array($result)){

					$data .=   '<tr>  
									<td class="text-center">'.$sl.'</td>
									<td class="text-center">'.$row['username'].'</td>
									<td class="text-center">
									    <button onclick="deleteStudent('.$row['id'].')" class="btn btn-outline-danger btn-sm">Delete</button>
									    <button onclick="reset('.$row['id'].')" class="btn btn-outline-warning btn-sm">Reset</button></td>
					    		</tr>';
					    		$sl++;
				}
				
			$data .= '</table>';
	    	echo $data;
	    }
	    else
		{
			$data = '<h5 class="text-danger text-center">Currently No Records Present !!</h5>';
			echo $data;
		}
	}

	
	//adding records in database

	$password = 'Welcome123*';
    $pass = md5($password);

	if(isset($_POST['username'])){
		$qry = "insert into admin (username , password) values ('$username','$pass')";
		mysqli_query($conn,$qry);
	}


	// username exist
	if(isset($_POST['val_username']))
	{
	    $val_username = $_POST['val_username'];
	    $valquery = "SELECT * FROM admin WHERE username = '$val_username'";
	    $val_res = mysqli_query($conn,$valquery);
	    if(mysqli_num_rows($val_res)>0)
 		{
  			echo "Username Already Exist";
 		}
 		else
 		{
 			echo "Registered";
 		}
	}

	//delete record
	if(isset($_POST['deleteid'])){
		$deleteid = $_POST['deleteid'];

		$deleteqry = "delete from admin where id = '$deleteid'";
		mysqli_query($conn,$deleteqry);

	}

	//reject journal
	if(isset($_POST['delete_jor_id'])){
		$deleteid = $_POST['delete_jor_id'];

		$deleteqry = "delete from admin where id = '$deleteid'";
		mysqli_query($conn,$deleteqry);

	}

	//reset password 
	if(isset($_POST['student_id'])){
		$student_id = $_POST['student_id'];

		$pass = 'Welcome123*';

		$reset_pass = md5($pass);

		$updateqry = "UPDATE `admin` SET `password`= '$reset_pass' WHERE `id` = '$student_id'";
		mysqli_query($conn,$updateqry);

	}

?>