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
		<link href="./css/blk-design-system.css" rel="stylesheet" />
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
					<br><h1> Sign up</h1> <br><br>
						<input placeholder='Email Address'  type='email' id='Email_Address' name='Email_Address' size='75' required >
						<br><br>
						<input placeholder='Username' name= 'Username' type='text' id='Username' size='75' required>
						<br><br>
						<input placeholder='Password' type='password' name= 'Password' id='Password' size='75' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}' title='Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters' required>
						<div align= 'center'>
						<input type='checkbox' onclick='Showpassword()'> show password
						 <div id='message'>
						  <h3 style='color:red;'>Password must contain the following:</h3>
						  <p id='letter' class='invalid'>at least one <b>lowercase</b> letter</p>
						  <p id='capital' class='invalid'>at least one <b>uppercase</b> letter</p>
						  <p id='number' class='invalid'>at least one <b>number</b></p>
						  <p id='length' class='invalid'>Minimum <b>8 characters</b></p>
						</div>
						<br><br>
						<input placeholder=Phone Number type='tel'  id='Phone_Number' name='Phone_Number' size='75' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}' title= 'please follow this format, xxx-xxx-xxxx'
            required>
						<br><br><br>
						<button style='width: 100; height: 35; margin-right:-10px;' type='submit' id='Register_Submit' name='Register_Submit' value='Register'> Register </button>
						<div class='container signin'>
						    <p>Already have an account? <a href='Homepage.php'>login</a>.</p>

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

	<style>
	#message {
		display: none;
	  color: #000;
	  position: relative;
	  padding: 10px;
	  margin-top: 10px;
	}

	#message p {
	  padding: 10px 35px;
	  font-size: 18px;
	}

	/* Add a green text color and a checkmark when the requirements are right */
	.valid {
	  color: green;
	}

	.valid:before {
	  position: relative;
	  left: -35px;
	  content: "\2713"
	}

	/* Add a red text color and an "x" icon when the requirements are wrong */
	.invalid {
	  color: red;
	}

	.invalid:before {
	  position: relative;
	  left: -35px;
	  content: "\00d7";
	}
	</style>
		</body>
</html>


<script>

var myInput = document.getElementById("Password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
}

  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}

function Showpassword() {
	var x = document.getElementById("Password");
	if (x.type === "password") {
		x.type = "text";
	} else {
		x.type = "password";
	}}

</script>
