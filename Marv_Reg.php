<?php
	session_start();
?>
<html>
	<head>

		<title> About Marv </title>
		<title> Registration </title>
		<meta charset="utf-8">
		  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet" />
  <link href="./assets/css/blk-design-system.css" rel="stylesheet" />
	</head>
	<body>
		<div id="Welcome_Bar"> <br>
			<span id="Greetings" class="Center"> <h1> Welcome to Marv<?php if (isset($_SESSION['Username'])) { echo ", "; echo $_SESSION['Username'];  echo "!"; }?> </h1></span>
			<span class="Welcome_Item"> <a href="Homepage.php"> Homepage </a> </span>
      <span class="Welcome_Item"> <a href="About_Marv.php"> About Marv </a> </span>
			<span class="Welcome_Item"> <a href="About_Us.php"> About Us </a> </span>
			<span class="Welcome_Item"> <a href="Use_Marv.php"> Use Marv </a> </span>
			<span Id="Final_Welcome_Item"> <a href="Contact_Us.php"> Contact Us </a> </span>
		</div>

        <div align='center'>
        <?php
			if (!isset($_SESSION['Username'])) { echo "
				<form method='POST' action='PHP_Actions/Login_Or_Register.php'>
					<br><h1> Register </h1> <br><br>
						<input placeholder='Email Address'  type='email' id='Email_Address' name='Email_Address' size='75' required >
						<br><br>
						<input placeholder='Username' name= 'Username' type='text' id='Username' size='75' required>
						<br><br>
						<input placeholder='Password' type='password' name= 'Password' id='Password' size='75' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}' title='Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters' required>
						<div align= 'center'>
						<input type='checkbox' onclick='Showpassword()'> show password
						 <div id='message'>
						  <h3>Password must contain the following:</h3>
						  <p id='letter' class='invalid'>A <b>lowercase</b> letter</p>
						  <p id='capital' class='invalid'>A <b>capital (uppercase)</b> letter</p>
						  <p id='number' class='invalid'>A <b>number</b></p>
						  <p id='length' class='invalid'>Minimum <b>8 characters</b></p>
						</div>
						<br><br>
						<input placeholder=Phone Number type='tel'  id='Phone_Number' name='Phone_Number' size='75' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}' title= 'please follow this format, xxx-xxx-xxxx'
            required>
						<br><br><br>
						<button style='width: 100; height: 35; margin-right:-10px;' type='submit' id='Register_Submit' name='Register_Submit' value='Register'> Register </button>
						<button style='width: 100; height: 35; margin-right:-10px;' type='submit' id='Login_Submit' name='Login_Submit' value='Login'> Login </button>
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


<script>
function Showpassword() {
	var x = document.getElementById("Password");
	if (x.type === "password") {
		x.type = "text";
	} else {
		x.type = "password";
	}}

</script>