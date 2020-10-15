<?php
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	//$mysqli = mysqli_connect("localhost", "u17023964", "mlpish", "u17023964");
	$mysqli = mysqli_connect("localhost", "root", "", "dbuser");

	$name = $_POST["regName"];
	$surname = $_POST["regSurname"];
	$email = $_POST["regEmail"];
	$pass = $_POST["regPass2"];
	$phone = $_POST["regNumber"];
	
	$result = $mysqli->query("SELECT email FROM tbusers WHERE email = '$email'");
	
	if(isset($_FILES["pp"]))
	{
		$query = "INSERT INTO tbusers (name, surname, email, password, phone)
				  SELECT * FROM (SELECT '$name', '$surname', '$email', '$pass', '$phone') AS tmp
				  WHERE NOT EXISTS (SELECT email FROM tbusers WHERE email = '$email') LIMIT 1;";
		
		$res = mysqli_query($mysqli, $query) == TRUE;
		
		$uploadFile = $_FILES["pp"];
		
		if(($uploadFile["type"] == "image/jpeg" || $uploadFile["type"] == "image/pjpeg" || $uploadFile["type"] == "image/png") && $uploadFile["size"] < 1000000)
		{
				$folderName = "../images/";
				
				$uploadFileName = $uploadFile["name"];
				
				$query = "SELECT * FROM tbusers WHERE email = '$email' AND password = '$pass'";
				$res = mysqli_query($mysqli, $query);

				$row = mysqli_fetch_array($res);
				$userid = $row["user_id"];
				
				$query = "	UPDATE
								tbusers 
							SET 
								pp = '$uploadFileName'
							WHERE
								email = '$email' AND password = '$pass'";
								
				$res = mysqli_query($mysqli, $query);

				move_uploaded_file($uploadFile["tmp_name"], $folderName .  $uploadFileName);
		}
	}
	else
	{
		$query = "INSERT INTO tbusers (name, surname, email, password, phone,)
				  SELECT * FROM (SELECT '$name', '$surname', '$email', '$pass', '$phone') AS tmp
				  WHERE NOT EXISTS (SELECT email FROM tbusers WHERE email = '$email') LIMIT 1;";
				  
		$res = mysqli_query($mysqli, $query) == TRUE;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta charset="utf-8">
	<meta name="author" content="Michael Smith">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
	<link rel="icon" type="image/png" href="../images/icon.png">
</head>
<body>
	<div class="container">
		<header>
			<img src="../images/logo.PNG" alt="Logo">
		</header>
		<form action="home.php" method="post">
		<?php
			if($result->num_rows == 0) 
			{
				if($res)
				{
					echo '<div class="alert alert-primary mt-5" role="alert">
							Your account has been created
						  </div>';
						  
					echo '<div class="row mt-3">
							<div class="col-12">
								<a href="home.php">
									<button type="submit" value="hidden" class="btn btn-light">
										<i class="fas fa-arrow-right"></i> Continue to Site
									</button>
									<input type="hidden" value="'; echo $email; echo '" name="email">
									<input type="hidden" value="'; echo $pass; echo '" name="pass">
								</a>
							</div>
					      </div>';
				}
				else
				{
					echo '<div class="alert alert-danger mt-5" role="alert">
							The account could not be created
						  </div>';
						  
					echo '<div class="row mt-3">
							<div class="col-12">
								<a href="../index.html">
									<button type="button" class="btn btn-light">
										<i class="fas fa-arrow-left"></i> Return to Login
									</button>
								</a>
							</div>
					  </div>';
				}
			}
			else 
			{
				echo '<div class="alert alert-primary mt-5" role="alert">
							Account "'; echo $email; echo '" is already registered
					  </div>';
					  
				echo '<div class="row mt-3">
							<div class="col-12">
								<a href="../index.html">
									<button type="button" class="btn btn-light">
										<i class="fas fa-arrow-left"></i> Return to Login
									</button>
								</a>
							</div>
					  </div>';
			}	
		?>
		</form>
	</div>
</body>
</html>