<?php
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "Marv_Related_Information");
?>

<html>
	<head>
		<title> Use Marv </title>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet" />
		<link href="./css/blk-design-system.css" rel="stylesheet" />
	</head>

	<body>
		<div id="Welcome_Bar"> <br>
			<span id="Greetings" class="Center"> <h1> Welcome to Marv<?php if (isset($_SESSION['Username'])) { echo ", "; echo $_SESSION['Username'];  echo "!"; }?> </h1></span>
			<span class="Welcome_Item"> <a href="Homepage.php"> Homepage </a> </span>
			<span class="Welcome_Item"> <a href="About_Marv.php"> About Marv </a> </span>
			<span class="Welcome_Item"> <a href="About_Us.php"> About Us </a> </span>
			<span class="Welcome_Item"> Use Marv </span>
			<span id="Final_Welcome_Item"> <a href="Contact_Us.php"> Contact Us </a> </span>

			<?php
				if (isset($_SESSION['Username'])) {
					$CurrentUsername = $_SESSION['Username'];
					$CurrentUserNumberQuery = mysqli_query($connection, "SELECT User_Number FROM `users` WHERE Username='$CurrentUsername'");
					
					while ($row = mysqli_fetch_assoc($CurrentUserNumberQuery)) {
						$CurrentUserNumber = $row["User_Number"];
						$AdminOrNot = mysqli_query($connection, "SELECT users.User_Number, user_account_type.Admin_Account FROM `users` INNER JOIN `user_account_type` on users.User_Number = user_account_type.Users_User_Number WHERE (user_account_type.Admin_Account != 0 && user_account_type.Users_User_Number = '$CurrentUserNumber')");
					
						if (mysqli_num_rows($AdminOrNot) > 0) {
							echo "<br> <span id='Admin_Menu_Link'> <a href='Admin_Menu.php'> Admin Menu </a> </span>";
						} 	
					}
				}
			?>

			<?php
				if (!isset($_SESSION['Username'])) { echo "
					<form class='Login_Or_Logout_Area Float_Right' method='POST' action='PHP_Actions/Login_Or_Register.php'>
						<h4 id='Login_Title'> Sign-in/Register </h4>
							<label for='Username' class='UsernameAndPassword'> Username: </label>
							<input type='text' name='Username' id='Username' required>
							<br><br>
							<label for='Password' class='UsernameAndPassword'> Password: </label>
							<input type='text' name='Password' id='Password' required>
							<br>
							<input type='submit' id='Login' class='Login_And_Register_Buttons Float_Right' name='Login' value='Login'>
					</form>
					<br>
					<a href='Marv_Reg.php'> <button id='Register_Button' class='Login_And_Register_Buttons Float_Right' name='Register_Button' value='Register'> Register </button> </a>";
				} else {
					echo "<div class='Login_Or_Logout_Area Float_Right'>
							<h4 id='Logout_Title'> Log Out </h4>
						  </div>";

				}
				
				if(!isset($_SESSION['Username'])) {
					echo '<script type="text/javascript">alert("Login is required to view page contents");</script>';
					 exit();
				 }

			?>
			<form id="Logout_Form" class="Float_Right" method="POST" action="PHP_Actions/Logout.php"> <br><br><br><br>
				<?php if (isset($_SESSION['Username'])) { echo "<input type='submit' id='Logout_Button' name='Logout' value='Log Out'>"; }

				?>

			</form>
		</div>
		
		<br><br>
		
		<form method="POST" action="">
            <h2 id="Main_Text"> Please paste the text of any news article in the box below, and then hit the button to check its validity. For the best accuracy, paste the entire text of the article in the box below, rather than just the article headline/title. </h2>
            <input id="Use_Marv_Box" type="text" id="Headline" name="Headline" style="width:30%;" required>
            <input type="submit" name="Use_Marv_Input" id="Use_Marv_Input" value="Click To See Article Validity" />
        </form>
        
        <div align="center">
        <?php
            if(isset($_POST['Use_Marv_Input'])) {
                $UserInput = $_POST['Headline'];
                $command = escapeshellcmd("MarvTest.py $UserInput");
                $output = shell_exec($command);
                echo "<textarea rows='8', cols='100', class='Center', disabled>'$output'</textarea>";
            }
        ?>
        </div>
	</body>
</html>