<?php
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	//$mysqli = mysqli_connect("localhost", "u17023964", "mlpish", "u17023964");
	$mysqli = mysqli_connect("localhost", "root", "", "dbuser");

	$email = $_POST["email"];
	$pass = $_POST["pass"];
	
	$name = isset($_POST["locName"]) ? $_POST["locName"] : false;
	$address = isset($_POST["locAddress"]) ? $_POST["locAddress"] : false;
	$description = isset($_POST["locDesc"]) ? $_POST["locDesc"] : false;
	$type = isset($_POST["locType"]) ? $_POST["locType"] : false;
	
	$res = null;
	
	if($name && $address && $description && $type)
	{
		$date = date("Y-m-d");
		
		$query = "INSERT INTO tblocations (name, address, description, type, date, email, password) 
				  VALUES ('$name', '$address', '$description', '$type', '$date', '$email', '$pass');";
		
		$res = mysqli_query($mysqli, $query) == TRUE;
		
		if(isset($_FILES["pic"]))
		{
			$uploadFile = $_FILES["pic"];
			
			if(($uploadFile["type"] == "image/jpeg" || $uploadFile["type"] == "image/pjpeg" || $uploadFile["type"] == "image/png") && $uploadFile["size"] < 1000000)
			{
					$folderName = "../images/";
					
					$uploadFileName = $uploadFile["name"];
					
					$query = "	UPDATE
									tblocations 
								SET 
									pic = '$uploadFileName'
								WHERE name = '$name' 
									AND address = '$address'
									AND description = '$description'
									AND type = '$type'";
									
					$res = mysqli_query($mysqli, $query);

					move_uploaded_file($uploadFile["tmp_name"], $folderName .  $uploadFileName);
			}
		}
	}
	
	if(isset($_POST["deleteLoc"]))
	{
		$locToDelete = $_POST["locToDelete"];
		$query = "DELETE FROM tblocations WHERE location_id = '$locToDelete'";
		$res = $mysqli->query($query);
	}
	
	if(isset($_POST["availInstruction"]))
	{
		$locToUpdate = $_POST["locToUpdate"];
		$availability = $_POST["availInstruction"];
		
		$query = "	UPDATE
						tblocations 
					SET 
						available = '$availability'
					WHERE 
						location_id = '$locToUpdate'";
						
		$res = $mysqli->query($query);
	}
	
	$newName = isset($_POST["newName"]) ? $_POST["newName"] : false;
	$newSurname = isset($_POST["newSurname"]) ? $_POST["newSurname"] : false;
	$newEmail = isset($_POST["newEmail"]) ? $_POST["newEmail"] : false;
	$newNumber = isset($_POST["newNumber"]) ? $_POST["newNumber"] : false;
	
	if($newName && $newSurname && $newEmail && $newNumber)
	{
		$query = "	UPDATE
						tbusers 
					SET 
						name = '$newName',
						surname = '$newSurname',
						email = '$newEmail',
						phone = '$newNumber'
					WHERE
						email = '$email'";
						
		$res = $mysqli->query($query);
		
		$query = "SELECT * FROM tbusers WHERE email = '$newEmail' AND password = '$pass'";
		$res = $mysqli->query($query);
		
		if($row = mysqli_fetch_array($res))
		{
			$email = $row["email"];
			$pass = $row["password"];
		}
		
		if(isset($_FILES["newpp"]))
		{
			$uploadFile = $_FILES["newpp"];
			
			if(($uploadFile["type"] == "image/jpeg" || $uploadFile["type"] == "image/pjpeg" || $uploadFile["type"] == "image/png") && $uploadFile["size"] < 1000000)
			{
					$folderName = "../images/";
					
					$uploadFileName = $uploadFile["name"];
					
					$query = "SELECT * FROM tbusers WHERE email = '$newEmail' AND password = '$pass'";
					$res = mysqli_query($mysqli, $query);

					$row = mysqli_fetch_array($res);
					$userid = $row["user_id"];
					
					$query = "	UPDATE
									tbusers 
								SET 
									pp = '$uploadFileName'
								WHERE
									email = '$newEmail' AND password = '$pass'";
									
					$res = mysqli_query($mysqli, $query);

					move_uploaded_file($uploadFile["tmp_name"], $folderName .  $uploadFileName);
			}
		}
	}
?>
<!DOCTYPE html>
<html id="top">
<head>
	<title>Profile</title>
	<meta charset="utf-8">
	<meta name="author" content="Michael Smith">
	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
	<link rel="icon" type="image/png" href="../images/icon.png">
</head>
<body>
	<div class="container">
		<header>
			<form action="home.php" method="post">
				<input type="image" src="../images/logo.PNG" alt="Logo" id="logo">
				<input type="hidden" value="<?php echo $email; ?>" name="email">
				<input type="hidden" value="<?php echo $pass; ?>" name="pass">
			</form>
		</header>
		<?php
			if($email && $pass)
			{
				$query = "SELECT * FROM tbusers WHERE email = '$email' AND password = '$pass'";
				$res = $mysqli->query($query);
				if($row = mysqli_fetch_array($res))
				{
					echo 	'<form action="home.php" method="post">
								<div class="row float-right">
									 <div class="col-auto">
										 <a href="#create">
											<div class="btn">
												<i class="fas fa-plus"></i> Add Location
											</div>
										 </a>
									 </div>
									 <div class="col-auto">
										 <a href="home.php">
											<button type="submit" value="hidden" class="btn">
												<i class="fas fa-home"></i> Return to Home
											</button>
											<input type="hidden" value="'; echo $email; echo '" name="email">
											<input type="hidden" value="'; echo $pass; echo '" name="pass">
										 </a>
									 </div>
									 <div class="col-auto">
										 <a href="../index.html">
											<div class="btn">
												<i class="fas fa-sign-out-alt"></i> Log Out
											</div>
										 </a>
									 </div>
								</div>
							 </form>
							 <div class="row mt-5"></div>';
							 
					echo	'<div class="row mt-5">
								<div class="col-lg-3 col-sm-6 mx-auto">
									<div class="card hovercard" style="text-align: center;">
										<div class="card-header">
											<legend>
												<i class="fas fa-user"></i> '.$row["name"].' '.$row["surname"].'
											</legend>
										</div>
										<div class="avatar">
											<img src="../images/'.$row["pp"].'" class="img-fluid" alt="Photo">
										</div>
										<div class="card-footer">
											<i class="fas fa-envelope"></i> '.$row["email"].'
										</div>
										<div class="card-footer">
											<i class="fas fa-phone"></i> '.$row["phone"].'
										</div>
									</div>
								</div>
							</div>';
							
					echo 	'<form action="edit.php" method="post">
								<div class="row mt-3">
									 <div class="col-auto mx-auto">
										<button type="submit" value="hidden" class="btn">
											<i class="fas fa-edit"></i> Edit Details
										</button>
										<input type="hidden" value="'; echo $email; echo '" name="email">
										<input type="hidden" value="'; echo $pass; echo '" name="pass">
									 </div>
								</div>
							 </form>';
				}
				
				$query = "SELECT * FROM tblocations WHERE email = '$email' AND password = '$pass' ORDER BY location_id DESC";
				$res = $mysqli->query($query);
				while($row = mysqli_fetch_array($res, MYSQLI_BOTH))
				{
					echo 	"<div class='card mt-5'>
								<div class='row no-gutters'>
									<div class='col-3'>
										<img src='../images/".$row['pic']."' class='img-fluid' alt='Photo'>
									</div>
									<div class='col'>
										<div class='card-block px-2'>
											<h4 class='card-title mt-3'>".$row['name']."</h4>
											<p class='card-text'>".$row['description']."</p>
										</div>
									</div>
								</div>
								<div class='card-footer'>
									<i class='fa fa-map-marker'></i> ".$row['address']."
								</div>
								<div class='card-footer'>
									Location type: ".$row['type']."
								</div>
								<div class='card-footer'>
									Available: ".$row['available']."
								</div>
								<div class='card-footer'>
									Posted: ".$row['date']."
								</div>
							</div>";
					
					if($row['available'] == 'Yes')
					{
						echo 	'<div class="row mt-3">
									 <div class="col-auto mx-auto">
										 <form action="profile.php" method="post">
											<button type="submit" value="hidden" class="btn">
												<i class="fas fa-trash"></i> Delete Location
											</button>
											<input type="hidden" value="'; echo $email; echo '" name="email">
											<input type="hidden" value="'; echo $pass; echo '" name="pass">
											<input type="hidden" value="'.$row['location_id'].'" name="locToDelete">
											<input type="hidden" value="delete" name="deleteLoc">
										 </form>
									 </div>
									 <div class="col-auto mx-auto">
										 <form action="profile.php" method="post">
											<button type="submit" value="hidden" class="btn">
												<i class="fas fa-times"></i> Make Unavailable
											</button>
											<input type="hidden" value="'; echo $email; echo '" name="email">
											<input type="hidden" value="'; echo $pass; echo '" name="pass">
											<input type="hidden" value="'.$row['location_id'].'" name="locToUpdate">
											<input type="hidden" value="No" name="availInstruction">
										 </form>
									 </div>
								</div>';
					}
					else
					{
						echo 	'<div class="row mt-3">
									 <div class="col-auto mx-auto">
										 <form action="profile.php" method="post">
											<button type="submit" value="hidden" class="btn">
												<i class="fas fa-trash"></i> Delete Location
											</button>
											<input type="hidden" value="'; echo $email; echo '" name="email">
											<input type="hidden" value="'; echo $pass; echo '" name="pass">
											<input type="hidden" value="'.$row['location_id'].'" name="locToDelete">
											<input type="hidden" value="delete" name="deleteLoc">
										 </form>
									 </div>
									 <div class="col-auto mx-auto">
										 <form action="profile.php" method="post">
											<button type="submit" value="hidden" class="btn">
												<i class="fas fa-check"></i> Make Available
											</button>
											<input type="hidden" value="'; echo $email; echo '" name="email">
											<input type="hidden" value="'; echo $pass; echo '" name="pass">
											<input type="hidden" value="'.$row['location_id'].'" name="locToUpdate">
											<input type="hidden" value="Yes" name="availInstruction">
										 </form>
									 </div>
								</div>';
					}
				}
				
				$query = "SELECT * FROM tbusers WHERE email = '$email' AND password = '$pass'";
				$res = $mysqli->query($query);
				if($row = mysqli_fetch_array($res))
				{
					echo 	'<section id="forms" class="mt-5 mb-5">
							  <div class="col-12 col-sm-6 mt-3 mt-sm-0 offset-sm-3">
								<div class="card">
									<form action="profile.php" method="post" enctype="multipart/form-data">
										<fieldset>
											<div class="card-header" id="create"><legend>Create new Location</legend></div>
											<div class="card-body">
												<div class="row">
													<div class="col-12 col-lg-6">
														<label for="locName">Name:</label>
														<input type="text" id="locName" class="form-control" placeholder="My apartment" required name="locName">
													</div>
													<div class="col-12 col-lg-6">
														<label for="locAddress">Address:</label>
														<input type="text" id="locAddress" class="form-control" placeholder="123 Boom Str" required name="locAddress">
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-12 col-lg-6">
														<label for="locDesc">Description:</label>
														<input type="text" id="locDesc" class="form-control" placeholder="Beautiful apartment" required name="locDesc">
													</div>
													<div class="col-12 col-lg-6 form-group">
													  <label for="locType">Type:</label>
													  <select class="form-control" id="locType" name="locType">
														<option>Apartment</option>
														<option>Flat</option>
														<option>Chalet</option>
														<option>House</option>
														<option>Mansion</option>
													  </select>
													</div>
												</div>
												<div class="row">
													<div class="col-12">
														<label for="picLabelLabel">Location Picture:</label>
														<div id="picLabelLabel" class="custom-file">
															<input type="file" class="custom-file-input" id="pic" name="pic">
															<label class="custom-file-label" id="picLabel" for="pic">Choose file...</label>
														</div>
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-12">
														<button type="submit" class="btn btn-light"><i class="fas fa-plus"></i> Create</button>
														<input type="hidden" value="'; echo $email; echo '" name="email">
														<input type="hidden" value="'; echo $pass; echo '" name="pass">
													</div>
												</div>
											</div>
										</fieldset>
									</form>
								</div>
							  </div>
							 </section>';
							 
					echo 	'<div class="row">
								 <div class="col-auto mx-auto mb-5">
									 <a href="#top">
										<div class="btn">
											<i class="fas fa-arrow-up"></i> Back to Top
										</div>
									 </a>
								 </div>
							</div>';
				}
			}
		?>
	</div>
</body>
<script type="text/javascript" src="../js/profileScript.js"></script>
</html>