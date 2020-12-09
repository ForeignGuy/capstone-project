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
			<h1 class="ml3">Welcome to Marv<span id="Greetings" class="Center"><?php if (isset($_SESSION['Username'])) { echo ", "; echo $_SESSION['Username'];  echo "!"; }?></span> </h1>
			<span> <img id="Logo" height="300px" width="300px" src="Logo_FINAL.png"> </img> </span>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script> <br>
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
							echo "<span id='Admin_Menu_Link'> <a href='Admin_Menu.php'> Admin Menu </a> </span>";
						}
					}
				}
			?>

			<?php
				if (!isset($_SESSION['Username'])) { 
				echo "<form class='Login_Or_Logout_Area Float_Right' method='POST' action='PHP_Actions/Login_Or_Register.php'>
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
";
					echo '<script type="text/javascript">alert("Login is required to view page contents");</script>';					
				} else {
					echo "<div class='Login_Or_Logout_Area Float_Right'>
							<form id='Logout_Form' class='Float_Right' method='POST' action='PHP_Actions/Logout.php'> 
								<h4 id='Logout_Title'> Log Out </h4>
								<br><br><br><br><br>
								<input type='submit' id='Logout_Button' name='Logout' value='Log Out'>
								<a id='Reset_Password_Link_Logged_In' href='Reset_Password.php'> <b> <u> Password Reset </u> </b> </a>
							</form>";
					echo "</div>";		
					echo "<form method='POST' action=''>
							<h3 id='Use_Marv_Heading'> Please paste the text of any news article in the box below, and then hit the button to check its validity. For the best accuracy, paste the headline of an article as opposed to a short phrase or the whole article. </h3> 
							<textarea id='Headline' name='Headline' rows='5' cols='120' placeholder='Article text goes here.' required></textarea>
							<br><br>
							<input type='submit' id='Headline_Submit' name='Use_Marv_Input' value='Click To See Article Validity'> </input>
						</form>
		
					<br>
					
					 <div align='center'>";
					if(isset($_POST['Use_Marv_Input'])) {
						$UserInput = $_POST['Headline'];
						set_time_limit(1000);
                				$output = shell_exec("MarvFinal.py ; C:\Users\Jacob Baum\anaconda3\bin\python -V 2>&1 $UserInput");
						$temp = str_replace("I tensorflow/stream_executor/platform/default/dso_loader.cc:49] Successfully opened dynamic library cudart64_110.dll", " ", $output);
                				echo "<textarea id='Output_Text_Area' rows='8' cols='100' class='Center' disabled>'$temp'</textarea>";
					}
				}
			?>
	</body>
</html>
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

.ml3 {
	text-align: left;

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
