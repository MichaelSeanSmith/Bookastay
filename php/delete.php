<?php
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	//$mysqli = mysqli_connect("localhost", "u17023964", "mlpish", "u17023964");
	$mysqli = mysqli_connect("localhost", "root", "", "dbuser");

	$email = $_POST["email"];
	$pass = $_POST["pass"];
	
	$query = "DELETE FROM tbusers WHERE email = '$email' AND password = '$pass'";
	$res = $mysqli->query($query);
	
	$query = "DELETE FROM tblocations WHERE email = '$email' AND password = '$pass'";
	$res = $mysqli->query($query);
?>
<!DOCTYPE html>
<html id="top">
<head>
	<title>Account Deleted</title>
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
			echo '<div class="alert alert-primary mt-5" role="alert">
						Your account has been deleted
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
		?>
	</div>
</body>
<script type="text/javascript" src="../js/editScript.js"></script>
</html>