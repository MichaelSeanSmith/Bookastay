<?php
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	//$mysqli = mysqli_connect("localhost", "u17023964", "mlpish", "u17023964");
	$mysqli = mysqli_connect("localhost", "root", "", "dbuser");

	$email = $_POST["email"];
	$pass = $_POST["pass"];
?>
<!DOCTYPE html>
<html id="top">
<head>
	<title>Edit Details</title>
	<meta charset="utf-8">
	<meta name="author" content="Michael Smith">
	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../style/style.css">
	<link rel="icon" type="image/png" href="../images/icon.png"></head>
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
					echo 	'<form action="profile.php" method="post">
								<div class="row float-right">
									 <div class="col-auto">
										 <a href="profile.php">
											<button type="submit" value="hidden" class="btn">
												<i class="fas fa-arrow-left"></i> Return to Profile
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
							 
					echo	'<div class="col-12 col-sm-6 mt-3 mt-sm-0 mx-auto mb-5">
								<div class="card mt-5">
									<form action="profile.php" method="post" enctype="multipart/form-data">
										<fieldset>
											<div class="card-header">
												<legend>
													<i class="fas fa-edit"></i> Edit Details
												</legend>
											</div>
											<div class="card-body">
												<div class="row">
													<div class="col-12 col-lg-6">
														<label for="newName">Name:</label>
														<input type="text" id="newName" class="form-control" value="'.$row['name'].'" required name="newName">
													</div>
													<div class="col-12 col-lg-6">
														<label for="newSurname">Surname:</label>
														<input type="text" id="newSurname" class="form-control" value="'.$row['surname'].'" required name="newSurname">
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-12 col-lg-6">
														<label for="newEmail">Email Address:</label>
														<input type="email" id="newEmail" class="form-control" value="'.$row['email'].'" required name="newEmail">
													</div>
													<div class="col-12 col-lg-6">
														<label for="newNumber">Contact Number:</label>
														<input type="number" id="newNumber" class="form-control" value="'.$row['phone'].'" required name="newNumber">
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-12">
														<label for="newuploadpp">Select New Profile Picture:</label>
														<div id="newuploadpp" class="custom-file">
															<input type="file" class="custom-file-input" id="newpp" name="newpp">
															<label class="custom-file-label" id="newppLabel" for="newpp">Choose file...</label>
														</div>
													</div>
												</div>
												<div class="row mt-3">
													<div class="col-12">
														<input type="hidden" value="'; echo $email; echo '" name="email">
														<input type="hidden" value="'; echo $pass; echo '" name="pass">
														<button type="submit" class="btn">
															<i class="fas fa-check"></i> Update Details
														</button>
													</div>
												</div>
											</div>
										</fieldset>
									</form>
								</div>
								<form action="verify.php" method="post">
									<div class="row mt-3">
										 <div class="col-auto mx-auto">
											<button type="submit" value="hidden" class="btn">
												<i class="fas fa-trash"></i> Delete Account
											</button>
											<input type="hidden" value="'; echo $email; echo '" name="email">
											<input type="hidden" value="'; echo $pass; echo '" name="pass">
										 </div>
									</div>
								 </form>
							</div>';
				}
			}
		?>
	</div>
</body>
<script type="text/javascript" src="../js/editScript.js"></script>
</html>