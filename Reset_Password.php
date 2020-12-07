<?php
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "Marv_Related_Information");
?>

<html>
	<head>
		<title> Reset Password </title>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet" />
		<link href="./css/blk-design-system.css" rel="stylesheet" />
	</head>

	<body>
		<div id="Welcome_Bar"> <br>
			<h1 class="ml3">Welcome to Marv<span id="Greetings" class="Center"><?php if (isset($_SESSION['Username'])) { echo ", "; echo $_SESSION['Username'];  echo "!"; }?></span> </h1>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
			<span class="Welcome_Item"> Homepage </span>
			<span class="Welcome_Item"> <a href="About_Marv.php"> About Marv </a> </span>
			<span class="Welcome_Item"> <a href="About_Us.php"> About Us </a> </span>
			<span class="Welcome_Item"> <a href="Use_Marv.php"> Use Marv </a> </span>
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
						<i class='fa fa-user icon'></i>
					 <input placeholder='Username' name= 'Username' type='text' id='Username'required>
					 <br><br>
					 <input placeholder='Password' type='password' name= 'Password' id='Password' required>
					 <i class='fa fa-lock icon'></i>
							<br>
							<input type='submit' id='Login' class='Login_And_Register_Buttons Float_Right' name='Login' value='Login'>
					</form>
					<br>
					<a href='Marv_Reg.php'> <button id='Register_Button' class='Login_And_Register_Buttons Float_Right' name='Register_Button' value='Register'> Register </button> </a>
			
					</div>	
					<br><br>
		
					<div id='Homepage_Main_Text_Div'>
						<h2 id='Main_Heading' class='Center'> Our Site </h2>";	
				} else {
					echo "<div class='Login_Or_Logout_Area Float_Right'>
							<form id='Logout_Form' class='Float_Right' method='POST' action='PHP_Actions/Logout.php'> 
								<h4 id='Logout_Title'> Log Out </h4>
								<br><br><br><br><br>
								<input type='submit' id='Logout_Button' name='Logout' value='Log Out'>
								<a id='Reset_Password_Link_Logged_In' href='Reset_Password.php'> <b> <u> Password Reset </u> </b> </a>
							</form>
							
						</div>
						
						<br><br>
		
						<div id='Homepage_Main_Text_Div'>
							<h2 id='Main_Heading_Logged_In' class='Center'> Password Reset </h2>";
				} 
			?>
			
			<h3 id="Reset_Password_Heading" class="Center"> To reset your password, please type the request information into the boxes below. </h3>
			<form method="POST" action="">
				<p id="Old_Password_Label"> Old Password: </p><input type="password" id="Old_Password_Input" name="Old_Password_Input" required></input> 
				<p id="New_Password_Label"> New Password: </p><input type="password" id="New_Password_Input" name="New_Password_Input" required></input>
				<br><br>
				<p id="Check_Password_Label"> Retype New Password: </p><input type="password" id="Check_Password_Input" name="Check_Password_Input" required></input>
				<br><br> <input type="submit" id="Reset_Password_Button" name="Reset_Password_Button" value="Change Password"></button>
			</form>
		</div>
  <script>
    $(document).ready(function() {
      blackKit.initDatePicker();
      blackKit.initSliders();
    });

    function scrollToDownload() {

      if ($('.section-download').length != 0) {
        $("html, body").animate({
          scrollTop: $('.section-download').offset().top
        }, 1000);
      }
    }
  </script>
	</body>
</html>

<?php
	if (isset($_POST['Reset_Password_Button'])) {
		$OldPassword = $_POST['Old_Password_Input'];	
		$NewPassword = $_POST['New_Password_Input'];
		$VerifyNewPassword = $_POST['Check_Password_Input'];
		
		if ($NewPassword == $VerifyNewPassword) {
			$HashedNewPassword = password_hash($NewPassword, PASSWORD_DEFAULT);
						
			$CheckEncryptedPassword = mysqli_query($connection, "SELECT `Password` FROM `users` WHERE Username='" . $_SESSION['Username'] . "'");
			
			while ($row = mysqli_fetch_assoc($CheckEncryptedPassword)) {
				$DatabasePassword = $row['Password'];
				
				$OldPassword = trim($OldPassword);
				$DatabasePassword = trim($DatabasePassword);
			
				$VerifyOldPassword = password_verify($OldPassword, $DatabasePassword);		
				
				$CheckPasswordResetMatch = mysqli_query($connection, "SELECT * FROM `users` WHERE (Username='" . $_SESSION['Username'] . "' AND Password='$OldPassword') OR (Username='" . $_SESSION['Username'] . "' AND '$VerifyOldPassword'=1)");
	
				if (mysqli_num_rows($CheckPasswordResetMatch) > 0) {
					mysqli_query($connection, "UPDATE `users` SET Password='$HashedNewPassword' WHERE Username='" . $_SESSION['Username'] . "'");
				} else {
					echo '<script type="text/javascript"> alert("Password incorrect. Try again."); </script>';
				}
			}
	} else {
		echo '<script type="text/javascript"> alert("Your new password was not correctly retyped into the provided password confirmation box. Please try again."); </script>';
	}
}
?>

<style>

#Login_Title{
position: relative;
	right: 20;
}
.icon {
position: absolute;
right: 220;
padding: 6px;
color: white;
text-align: right;
}

input{
	display: block;
	float: right;

}
.ml3{
	text-align: center;

}
</style>
<script>
// Wrap every letter in a span
var textWrapper = document.querySelector('.ml3');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({loop: true})
  .add({
    targets: '.ml3 .letter',
    opacity: [0,1],
    easing: "easeInOutQuad",
    duration: 2250,
    delay: (el, i) => 150 * (i+1)
  }).add({
    targets: '.ml3',
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 1000
  });
</script>
