<?php
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "Marv_Related_Information");
	
	if (isset($_POST['Login'])) {
		$UserUsername = $_POST['Username'];
		$UserPassword = $_POST['Password'];
		$hashpass2 = $_SESSION['hash'];
		if (mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `Users` WHERE (Username = '$UserUsername') AND (Password = '$hashpass2')")) > 0) {
			$_SESSION['Username'] = $UserUsername;
			header("Location: ../Homepage.php");
		} else {
			echo '<script type="text/javascript"> alert("No matching file for that username."); </script>';
			echo '<script type="text/javascript"> window.location.href="../Marv_Reg.php" </script>';
		}

	} else if (isset($_POST['Register_Submit'])) {
		$UserUsername = $_POST['Username'];
		$UserPassword = $_POST['Password'];
		$hashpass = password_hash($UserPassword, PASSWORD_DEFAULT);
		$UserEmail = $_POST['Email_Address'];
		$UserPhone = $_POST['Phone_Number'];
		if (mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `Users` WHERE (Username = '$UserUsername')")) < 1) {
			mysqli_query($connection, "INSERT INTO `Users` (Username, Password, Email_Address, Phone_Number) VALUES ('$UserUsername', '$hashpass','$UserEmail','$UserPhone')");
			$CurrentUserNumber = mysqli_insert_id($connection);
			mysqli_query($connection, "INSERT INTO `user_account_type` (Users_User_Number, Admin_Account) VALUES ($CurrentUserNumber, 0)");
			$_SESSION['hash'] = $hashpass;
			header("Location: ../Homepage.php");
		} else {
			echo '<script type="text/javascript"> alert("That username already exists! Try another one."); </script>';
			echo '<script type="text/javascript"> window.location.href="../Marv_Reg.php" </script>';
		}

	} else {
		echo '<script type="text/javascript"> alert("We cannot tell if you were registering or logging in. Please contact us and notify us about this issue."); </script>';
		echo '<script type="text/javascript"> window.location.href="../Homepage.php" </script>';
	}

?>