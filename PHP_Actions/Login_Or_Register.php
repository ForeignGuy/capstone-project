<?php
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "Marv_Related_Information");
	
	if (isset($UserPassword)) {
		$UserPassword = $_POST['Password'];

	} else {
		$UserPassword = null;
	}
	
	if (isset($_POST['Login'])) {
		$UserUsername = $_POST['Username'];
		$UserPassword = $_POST['Password'];
		$UserPasswordResultsObject = mysqli_query($connection, "SELECT `Password` FROM `users` WHERE Username='$UserUsername'");
		while ($row = mysqli_fetch_assoc($UserPasswordResultsObject)) {
			$DatabasePassword = $row["Password"];	
			$UserPassword = trim($UserPassword);
			$DatabasePassword = trim($DatabasePassword);
			
			$checkmatch = password_verify($UserPassword, $DatabasePassword);
			if (mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `Users` WHERE (Username = '$UserUsername') AND (Password = '$UserPassword' OR ('$checkmatch'=1))")) > 0) {
				$_SESSION['Username'] = $UserUsername;
				header("Location: ../Homepage.php");
			} else {
				echo '<script type="text/javascript"> alert("Username or password not found."); </script>';
				echo '<script type="text/javascript"> window.location.href="../Marv_Reg.php" </script>';
			}

		}
	} else if (isset($_POST['Register_Submit'])) {
		$UserUsername = $_POST['Username'];
		$UserPassword = $_POST['Password'];
		$UserEmail = $_POST['Email_Address'];
		if (isset($_POST['Phone_Number']) AND ($_POST['Phone_Number'] !== "")) {
			$_SESSION['Phone_Number'] = $_POST['Phone_Number'];
		} else {
			$_SESSION['Phone_Number'] = null;
		}
		
		$CheckForEmail = mysqli_query($connection, "SELECT * FROM `users` WHERE Email_Address='$UserEmail'");
		$CheckForPhone = mysqli_query($connection, "SELECT * FROM `users` WHERE Phone_Number='" . $_SESSION['Phone_Number'] . "'");
		if ((mysqli_num_rows($CheckForPhone) < 1) OR ($_SESSION['Phone_Number'] == null)) {
			if (mysqli_num_rows($CheckForEmail) < 1) {
				$hashpass = password_hash($UserPassword, PASSWORD_DEFAULT);
				if (mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `Users` WHERE (Username = '$UserUsername')")) < 1) {
					mysqli_query($connection, "INSERT INTO `Users` (Username, Password, Email_Address, Phone_Number) VALUES ('$UserUsername', '$hashpass','$UserEmail','" . $_SESSION['Phone_Number'] . "')");
					$CurrentUserNumber = mysqli_insert_id($connection);
					mysqli_query($connection, "INSERT INTO `user_account_type` (Users_User_Number, Admin_Account) VALUES ($CurrentUserNumber, 0)");
					header("Location: ../Homepage.php");
				} else {
					echo '<script type="text/javascript"> alert("That username already exists! Try another one."); </script>';
					echo '<script type="text/javascript"> window.location.href="../Marv_Reg.php" </script>';
				}
			} else {
				echo '<script type="text/javascript"> alert("That email address is already in use! Try another one."); </script>';
				echo '<script type="text/javascript"> window.location.href="../Marv_Reg.php" </script>';
			}
		} else {
			echo '<script type="text/javascript"> alert("That phone number already exists! Try another one."); </script>';
			echo '<script type="text/javascript"> window.location.href="../Marv_Reg.php" </script>';
		}

	} else {
		echo '<script type="text/javascript"> alert("We cannot tell if you were registering or logging in. Please contact us and notify us about this issue."); </script>';
		echo '<script type="text/javascript"> window.location.href="../Homepage.php" </script>';
	}

?>