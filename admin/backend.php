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

		$displayqry = "select * from student order by id DESC";
		$result = mysqli_query($conn,$displayqry);
		if(mysqli_num_rows($result) > 0)
		{

			$data = '<table class="table table-bordered">
						<thead>
							<th class="text-center">SL.NO</th>
							<th class="text-center">Name</th>
							<th class="text-center">Email</th>
							<th class="text-center">View | Update | Delete | Reset</th>
						</thead>';
			
				$sl = 1;

				while($row = mysqli_fetch_array($result)){

					$data .=   '<tr>  
									<td class="text-center">'.$sl.'</td>
									<td class="text-center">'.$row['name'].'</td>
									<td class="text-center">'.$row['email'].'</td>
									<td class="text-center"><button onclick="viewdetails('.$row['id'].')" class="btn btn-outline-primary btn-sm">View</button>
									    <button onclick="getdetails('.$row['id'].')" class="btn btn-outline-success btn-sm">Update</button>
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

	//pending journal

	if(isset($_POST['readRecordsPending'])){

		$displayqry = "select * from journal WHERE status = 'Pending' or status = 'Hidden' order by id DESC";
		$result = mysqli_query($conn,$displayqry);
		if(mysqli_num_rows($result) > 0)
		{

			$data = '<table class="table table-bordered">
						<thead>
							<th class="text-center">SL.NO</th>
							<th class="text-center">Name</th>
							<th class="text-center">Published By</th>
							<th class="text-center">Title</th>
							<th class="text-center">Catagory</th>
							<th class="text-center">Date</th>
							<th class="text-center">View | Accept | Reject</th>
						</thead>';
			
				$sl = 1;

				while($row = mysqli_fetch_array($result)){

					$data .=   '<tr>  
									<td class="text-center">'.$sl.'</td>
									<td class="text-center">'.$row['Name'].'</td>
									<td class="text-center">'.$row['author'].'</td>
									<td class="text-center">'.$row['title'].'</td>
									<td class="text-center">'.$row['categories'].'</td>
									<td class="text-center">'.$row['date'].'</td>
									<td class="text-center"><a href="'.$row['file_name'].'" target="_blank"><button class="btn btn-outline-primary btn-sm">View</button></a>
									    <button onclick="chngstatus('.$row['id'].')" class="btn btn-outline-success btn-sm">Accept</button>
									    <button onclick="deleteJournal('.$row['id'].')" class="btn btn-outline-danger btn-sm">Delete</button></td>
					    		</tr>';
					    		$sl++;
				}
				
			$data .= '</table>';
	    	echo $data;
	    }
	    else
		{
			$data = '<h5 class="text-success text-center">Currently No Pending Journals !!</h5>';
			echo $data;
		}
	}

	//accepted journals

	if(isset($_POST['readRecordsAccepted'])){

		$displayqry = "select * from journal WHERE status = 'Published' order by id DESC";
		$result = mysqli_query($conn,$displayqry);
		if(mysqli_num_rows($result) > 0)
		{

			$data = '<table class="table table-bordered">
						<thead>
							<th class="text-center">SL.NO</th>
							<th class="text-center">Name</th>
							<th class="text-center">Published By</th>
							<th class="text-center">Title</th>
							<th class="text-center">Catagory</th>
							<th class="text-center">Date</th>
							<th class="text-center">View | Hide | Delete</th>
						</thead>';
			
				$sl = 1;

				while($row = mysqli_fetch_array($result)){

					$data .=   '<tr>  
									<td class="text-center">'.$sl.'</td>
									<td class="text-center">'.$row['Name'].'</td>
									<td class="text-center">'.$row['author'].'</td>
									<td class="text-center">'.$row['title'].'</td>
									<td class="text-center">'.$row['categories'].'</td>
									<td class="text-center">'.$row['date'].'</td>
									<td class="text-center"><a href="'.$row['file_name'].'" target="_blank"><button class="btn btn-outline-primary btn-sm">View</button></a>
									    <button onclick="hide('.$row['id'].')" class="btn btn-outline-warning btn-sm">Hide</button>
									    <button onclick="deleteJournal('.$row['id'].')" class="btn btn-outline-danger btn-sm">Delete</button></td>
					    		</tr>';
					    		$sl++;
				}
				
			$data .= '</table>';
	    	echo $data;
	    }
	    else
		{
			$data = '<h5 class="text-danger text-center">Currently No Accepted Journals !!</h5>';
			echo $data;
		}
	}

	//adding records in database

	$password = 'Welcome123*';
    $pass = md5($password);

	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['usn']) && isset($_POST['dept'])){
		$qry = "insert into student (name , email , mobile , usn , dept , username , password) values ('$name','$email','$mobile','$usn','$dept','$email','$pass')";
		mysqli_query($conn,$qry);
	}


	// email exist
	if(isset($_POST['val_email']))
	{
	    $val_email = $_POST['val_email'];
	    $valquery = "SELECT * FROM student WHERE email = '$val_email'";
	    $val_res = mysqli_query($conn,$valquery);
	    if(mysqli_num_rows($val_res)>0)
 		{
  			echo "Email Already Exist";
 		}
 		else
 		{
 			echo "Registered";
 		}
	}

	//delete record
	if(isset($_POST['deleteid'])){
		$deleteid = $_POST['deleteid'];

		$deleteqry = "delete from student where id = '$deleteid'";
		mysqli_query($conn,$deleteqry);

	}

	//reject journal
	if(isset($_POST['delete_jor_id'])){
		$deleteid = $_POST['delete_jor_id'];


		$valquery = "SELECT * FROM journal WHERE id = '$deleteid'";
	    $val_res = mysqli_query($conn,$valquery);
	    $row = mysqli_fetch_assoc($val_res);

	    $path = $row['file_name'];

	    unlink($path);


		$deleteqry = "delete from journal where id = '$deleteid'";
		mysqli_query($conn,$deleteqry);

	}


	//accept journal 
	if(isset($_POST['jor_id'])){
		$jor_id = $_POST['jor_id'];

		$updateqry = "UPDATE `journal` SET `status`= 'Published' WHERE `id` = '$jor_id'";
		mysqli_query($conn,$updateqry);

	}

	//hide jounnal 
	if(isset($_POST['jor_hide_id'])){
		$jor_hide_id = $_POST['jor_hide_id'];

		$updateqry = "UPDATE `journal` SET `status`= 'Hidden' WHERE `id` = '$jor_hide_id'";
		mysqli_query($conn,$updateqry);

	}

	//reset password 
	if(isset($_POST['student_id'])){
		$student_id = $_POST['student_id'];

		$pass = 'Welcome123*';

		$reset_pass = md5($pass);

		$updateqry = "UPDATE `student` SET `password`= '$reset_pass' WHERE `id` = '$student_id'";
		mysqli_query($conn,$updateqry);

	}


	//get data 
	if(isset($_POST['updateid']) && isset($_POST['updateid']) != "")
	{
	    $user_id = $_POST['updateid'];
	    $query = "SELECT * FROM student WHERE id = '$user_id'";
	    if (!$result = mysqli_query($conn,$query)) {
	        exit(mysqli_error());
	    }
	    
	    $response = array();

	    if(mysqli_num_rows($result) > 0) {
	        while ($row = mysqli_fetch_assoc($result)) {
	       
	            $response = $row;
	        }
	    }
	    else
	    {
	        $response['status'] = 200;
	        $response['message'] = "Data not found!";
	    }

	    echo json_encode($response);
	}
	else
	{
	    $response['status'] = 200;
	    $response['message'] = "Invalid Request!";
	}



	// update student record
	if(isset($_POST['updatename']) && isset($_POST['updateemail']) && isset($_POST['updatemobile']) && isset($_POST['updateusn']) && isset($_POST['hidden_student_id']) )
	{

		$updateqry = "UPDATE `student` SET `name`= '$updatename' ,`email`= '$updateemail',`mobile`= '$updatemobile',`usn`= '$updateusn',`username`= '$updateemail' WHERE `id` = '$hidden_student_id'";

		mysqli_query($conn,$updateqry);
	}




	if(isset($_POST['val_update_email']))
	{
	    $val_update_email = $_POST['val_update_email'];
	    $hidden_student_id = $_POST['hidden_student_id'];

	    $updatevalquery = "SELECT * FROM student WHERE email = '$val_update_email' AND id <> '$hidden_student_id' ";
	    $update_val_res = mysqli_query($conn,$updatevalquery);
	    if(mysqli_num_rows($update_val_res)>0)
 		{
  			echo "Email Id Already Registered !!";
 		}
 		else
 		{
 			echo "Updated";
 		}
	}


	//view data in modal
	if(isset($_POST['viewid']) && isset($_POST['viewid']) != "")
	{
	    $viewid = $_POST['viewid'];
	    $viewquery = "SELECT * FROM student WHERE id = '$viewid'";
	    if (!$viewresult = mysqli_query($conn,$viewquery)) {
	        exit(mysqli_error());
	    }
	    
	    $viewresponse = array();

	    if(mysqli_num_rows($viewresult) > 0) {
	        while ($viewrow = mysqli_fetch_assoc($viewresult)) {
	       
	            $viewresponse = $viewrow;
	        }
	    }
	    else
	    {
	        $viewresponse['status'] = 200;
	        $viewresponse['message'] = "Data not found!";
	    }

	    echo json_encode($viewresponse);
	}
	else
	{
	    $viewresponse['status'] = 200;
	    $viewresponse['message'] = "Invalid Request!";
	}
?>