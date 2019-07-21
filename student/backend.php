<?php include 'dbcon.php';?>
<?php
session_start();

  if(!isset($_SESSION['email']))
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

	$email = $_SESSION['email'];
    $qry = "SELECT * FROM `student` WHERE `email`='$email';";
    $res = $mysqli->query($qry) or die(error.__LINE__);
    $row = mysqli_fetch_assoc($res);

    $author_id = $row['id'];

		$displayqry = "SELECT * FROM journal WHERE author_id = '$author_id' ORDER BY id DESC";
		$result = mysqli_query($conn,$displayqry);
		if(mysqli_num_rows($result) > 0)
		{

			$data = '<table class="table table-bordered">
						<thead>
							<th class="text-center">SL.NO</th>
							<th class="text-center">Title</th>
							<th class="text-center">Catagory</th>
							<th class="text-center">Date</th>
							<th class="text-center">Download</th>
							<th class="text-center">Delete</th>
							<th class="text-center">Status</th>
						</thead>';
			
				$sl = 1;

				while($row = mysqli_fetch_array($result)){

					$data .=   '<tr>  
									<td class="text-center">'.$sl.'</td>
									<td class="text-center">'.$row['title'].'</td>
									<td class="text-center">'.$row['categories'].'</td>
									<td class="text-center">'.$row['date'].'</td>
									<td class="text-center"><a href="'.$row['file_name'].'" target="_blank">Download</a></td>
									<td class="text-center"><button onclick="deleteJournal('.$row['id'].')" class="btn btn-outline-danger btn-sm">Delete</button></td>
									<td class="text-center">'.$row['status'].'</td>
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


	//delete journal
	if(isset($_POST['deleteid'])){
		$deleteid = $_POST['deleteid'];

		$valquery = "SELECT * FROM journal WHERE id = '$deleteid'";
	    $val_res = mysqli_query($conn,$valquery);
	    $row = mysqli_fetch_assoc($val_res);

	    $path = $row['file_name'];

	    unlink($path);

		$deleteqry = "delete from journal where id = '$deleteid'";
		mysqli_query($conn,$deleteqry);

	}

?>