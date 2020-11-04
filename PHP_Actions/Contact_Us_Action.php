<?php
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "Marv_Related_Information");
	
	if (isset($_POST['Feedback_Submit'])) {
		$UserInput = $_POST['Feedback_Box'];
		$UserUsername = $_SESSION['Username'];
		$UserNumberResultsObject = mysqli_query($connection, "SELECT User_Number FROM `users` WHERE Username='$UserUsername'");
		while ($row = mysqli_fetch_assoc($UserNumberResultsObject)) {
			$UserNumber = $row["User_Number"];
			mysqli_query($connection, "INSERT INTO `user_comments` (Comment_Text, Users_User_Number) VALUES ('$UserInput', $UserNumber)");
			echo '<script type="text/javascript"> alert("Thank you for providing us feedback!"); </script>';
			echo '<script type="text/javascript"> window.location.href="../Homepage.php" </script>';
		}
	} else {
			echo '<script type="text/javascript"> alert("You should not be seeing this!"); </script>';
			echo '<script type="text/javascript"> window.location.href="../Homepage.php" </script>';
	}
?>