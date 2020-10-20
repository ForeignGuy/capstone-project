<?php 
	session_start();
?>

<html>
	<head> 
		<title> Homepage </title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="CSS/Main.css">
		<link rel="stylesheet" type="text/css" href="CSS/Use_Marv.css">
	</head>
	
	<body>
		<div id="Welcome_Bar"> <br>
			<span id="Greetings" class="Center"> <h1> Welcome to Marv<?php if (isset($_SESSION['Username'])) { echo ", "; echo $_SESSION['Username'];  echo "!"; }?> </h1></span>
			<span class="Welcome_Item"> <a href="Homepage.php"> Homepage </a> </span> 
			<span class="Welcome_Item"> <a href="About_Marv.php"> About Marv </a> </span> 
			<span class="Welcome_Item"> <a href="About_Us.php"> About Us </a> </span> 
			<span class="Welcome_Item"> <a href="Use_Marv.php"> Use Marv </a> </span> 
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
					
				} else {
					echo "<div class='Login_Or_Logout_Area Float_Right'> 
							<h4 id='Logout_Title'> Log Out </h4>
						  </div>";
				}
			?>
			<form id="Logout_Form" class="Float_Right" method="POST" action="PHP_Actions/Logout.php"> <br><br><br><br>
				<?php if (isset($_SESSION['Username'])) { echo "<input type='submit' id='Logout_Button' name='Logout' value='Log Out'>"; } ?>
			</form>
		</div>
		
		<div id="Marv_Welcome_Div"> 
			<form method='POST' action="PHP_Actions/Use_Marv_Action.php">
				<p id="Marv_Welcome_Paragraph"> Hello, and welcome to the interface for using MARV. At the moment, user input cannot be accepted, though clicking the button below will see MARV's estimation
				of its accuracy in detecting fake news. </p>
				<input type="submit" value="Use Marv" id="Use_Marv_Button"> 
			</form>
		</div>
	</body>
</html>
