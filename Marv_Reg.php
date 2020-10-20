<?php 
	session_start();
?>

<html>
	<head> 
		<title> About Marv </title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="CSS/Main.css">
	</head>
	
	<body>
		<div id="Welcome_Bar"> <br>
			<span id="Greetings" class="Center"> <h1> Welcome to Marv<?php if (isset($_SESSION['Username'])) { echo ", "; echo $_SESSION['Username'];  echo "!"; }?> </h1></span>
			<span class="Welcome_Item"> <a href="Homepage.php"> Homepage </a> </span> 
			<span class="Welcome_Item"> About Marv </span> 
			<span class="Welcome_Item"> <a href="About_Us.php"> About Us </a> </span> 
			<span class="Welcome_Item"> <a href="Use_Marv.php"> Use Marv </a> </span> 
			<span Id="Final_Welcome_Item"> <a href="Contact_Us.php"> Contact Us </a> </span>
		</div>
        
        <div>
        <?php 
				if (!isset($_SESSION['Username'])) { echo "
					<form method='POST' action='PHP_Actions/Login_Or_Register.php'> 
						<h1 id='Login_Title'> Register </h1> 
							<label for='Email_Address'> Email Addess: </label>
							<input type='text' name='Email_Address' id='Email_Address' size='75' required>
							
							<br><br>
							
							<label for='Username'> Username: </label>
							<input type='text' name='Username' id='Username' size='75' required>
							
							<br><br>
                            
                            <label for='Password'> Password: </label>
							<input type='text' name='Password' id='Password' size='75' required>
							
							<br><br>
                            
                            <label for='Phone_Number'> Phone Number: </label>
							<input type='text' name='Phone_Number' id='Phone_Number' size='75' optional>
							
							<br><br>

							<input type='submit' id='Register' name='Register' value='Register'>
					</form>";
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
	</body>
</html>