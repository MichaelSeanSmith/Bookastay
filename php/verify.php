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
	<title>Delete Account</title>
	<meta charset="utf-8">
	<meta name="author" content="Michael Smith">
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
							 
					echo '<div class="alert alert-primary mt-5" role="alert">
								Are you sure you want to delete your account? All your information and listed locations will be removed.
						  </div>';
						  
					echo '<div class="row mt-3">
								<form action="delete.php" method="post">
									<div class="col-auto">
										<button type="submit" style="width: 5em;" class="btn btn-light">Yes</button>
										<input type="hidden" value="'; echo $email; echo '" name="email">
										<input type="hidden" value="'; echo $pass; echo '" name="pass">
									</div>
								</form>
								<form action="profile.php" method="post">
									<div class="col-auto">
										<button type="submit" style="width: 5em;" class="btn btn-light">No</button>
										<input type="hidden" value="'; echo $email; echo '" name="email">
										<input type="hidden" value="'; echo $pass; echo '" name="pass">
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