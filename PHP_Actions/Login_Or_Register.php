<?php
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "Marv_Related_Information");
	
	$UserUsername = $_POST['Username'];
	$UserPassword = $_POST['Password'];
	
	if (isset($_POST['Login'])) {
		if (mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `users` WHERE (Username = $UserUsername) AND (Password = $UserPassword)")) > 0) {
			$_SESSION['Username'] = $UserUsername;
			header("Location: ../Homepage.php");
		} else {
			echo '<script type="text/javascript"> alert("Your login information does not match any existing records."); </script>';
			echo '<script type="text/javascript"> window.location.href="../Homepage.php" </script>';
		}
	
	} else if (isset($_POST['Register_Submit'])) {
		if (mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `user_accounts` WHERE (Username = $UserUsername)")) < 1) {
			mysqli_query($connection, "INSERT INTO `user_accounts` (Username, Password) VALUES ('$UserUsername', '$UserPassword')");
			header("Location: ../Homepage.php");
		} else {
			echo '<script type="text/javascript"> alert("That username already exists! Try another one."); </script>';
			echo '<script type="text/javascript"> window.location.href="../Homepage.php" </script>';
		}
	
	} else {
		echo '<script type="text/javascript"> alert("We cannot tell if you were registering or logging in. Please contact us and notify us about this issue."); </script>';
		echo '<script type="text/javascript"> window.location.href="../Homepage.php" </script>';
	}

?>