<?php
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	//$mysqli = mysqli_connect("localhost", "u17023964", "mlpish", "u17023964");
	$mysqli = mysqli_connect("localhost", "root", "", "dbuser");

	$email = $_POST["email"];
	$pass = $_POST["pass"];
	$visitProfile = $_POST["visitProfile"];
?>
<!DOCTYPE html>
<html id="top">
<head>
	<title>Profile</title>
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
			<form action="home.php" method="post">
				<input type="image" src="../images/logo.PNG" alt="Logo" id="logo">
				<input type="hidden" value="<?php echo $email; ?>" name="email">
				<input type="hidden" value="<?php echo $pass; ?>" name="pass">
			</form>
		</header>
		<?php
			if($email && $pass)
			{
				$query = "SELECT * FROM tbusers WHERE email = '$visitProfile'";
				$res = $mysqli->query($query);
				if($row = mysqli_fetch_array($res))
				{
					echo 	'<form action="home.php" method="post">
								<div class="row float-right">
									 <div class="col-auto">
										 <a href="home.php">
											<button type="submit" value="hidden" class="btn">
												<i class="fas fa-home"></i> Return to Home
											</button>
											<input type="hidden" value="'; echo $email; echo '" name="email">
											<input type="hidden" value="'; echo $pass; echo '" name="pass">
											<input type="hidden" value="'; echo "global"; echo '" name="feed">
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
				}
				
				$query = "SELECT * FROM tblocations WHERE email = '$visitProfile' ORDER BY location_id DESC";
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
							</div>";
				}
				
				echo 	'<div class="row">
							 <div class="col-auto mx-auto mt-5 mb-5">
								 <a href="#top">
									<div class="btn">
										<i class="fas fa-arrow-up"></i> Back to Top
									</div>
								 </a>
							 </div>
						</div>';
			}
		?>
	</div>
</body>
</html>