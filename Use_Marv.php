<?php
	session_start();
?>



<html>
	<head>
		<title> Use Marv </title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="CSS/Main.css">
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

				if (!isset($_SESSION['Username'])) { echo "
					<form class='Login_Or_Logout_Area Float_Right' method='POST' action='PHP_Actions/Login_Action.php'> 
						<h4 id='Login_Title'> Sign-in/Register </h4> 
							<label for='Username' class='UsernameAndPassword'> Username: </label>
							<input type='text' name='Username' id='Username' required>
							
							<br><br>
							
							<label for='Password' class='UsernameAndPassword'> Password: </label>
							<input type='text' name='Password' id='Password' required>
							
							<br>
 
							<input type='submit' id='Login' class='Login_And_Register_Buttons Float_Right' name='Login' value='Login'>
					</form>
					
					<a href='Marv_Reg.php'> <button id='Register' class='Login_And_Register_Buttons Float_Right' name='Register' value='Register'> Register </button> </a>";
				}
				
				if(!isset($_SESSION['Username'])) {
					echo '<script type="text/javascript">alert("LoginRequired");</script>';
						 exit();

				 }
			?>
			<form id="Logout_Form" class="Float_Right" method="POST" action="PHP_Actions/Logout.php"> <br><br><br><br>
				<?php if (isset($_SESSION['Username'])) { echo "<input type='submit' id='Logout_Button' name='Logout' value='Log Out'>"; } ?>
			</form>
		</div>

		<form method='POST' action="PHP_Actions/Use_Marv.php">
			<input type="submit" value="Use Marv">
		</form>
	</body>
</html>
