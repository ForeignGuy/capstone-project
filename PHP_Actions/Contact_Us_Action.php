<?php
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "Marv_Related_Information");
	
	$LoggedInUsername = $_SESSION['Username'];
	$UserText = $_POST['Feedback_Box'];
	$LoggedInUserIdChecker = mysqli_query($connection, "SELECT User_Number FROM `users` WHERE Username='$LoggedInUsername'");
	
	while ($row = mysqli_fetch_array($LoggedInUserIdChecker)) {
		$UserId = $row[0];
		mysqli_query($connection, "INSERT INTO `user_comments` (Comment_Text, Users_User_Number) VALUES ('$UserText', $UserId)");
		
		echo '<script type="text/javascript"> alert("Thank you for submitting your feedback! It has been recorded, and we will use it to improve in the future."); </script>';
		echo '<script type="text/javascript"> window.location.href="../Homepage.php" </script>';
	}
?>