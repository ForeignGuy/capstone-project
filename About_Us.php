<?php 
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "Marv_Related_Information");
?>

<html>
	<head> 
		<title> About Us </title>
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
			<span class="Welcome_Item"> About Us </span> 
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
			?>
			<form id="Logout_Form" class="Float_Right" method="POST" action="PHP_Actions/Logout.php"> <br><br><br><br>
				<?php if (isset($_SESSION['Username'])) { echo "<input type='submit' id='Logout_Button' name='Logout' value='Log Out'>"; } ?>
			</form>
		</div>
		
		<br><br>
		
		<div id="About_Marv_Main_Text_Div">
			<h2 id="Main_Heading" class="Center"> Who We Are </h2>
			<p id="Main_Text"> Our Team is comprised of Oakland University undergraduates in The School of Engineering and Computer Science at Oakland University. Our group has created Marv in our Senior Capstone Project class. This project is the culmination of our times at the university, but it also shows our ability to move past our comfort zones. 
			
			<br><br> 
			
			The overall methodology that our group used to complete our project was "divide and conquer." Each member in our group has certain strengths and certain weaknesses for coding, and after recognizing these strengths and weaknesses, we've assigned tasks based on them. 
			
			<h4 class="Center"> Our team consists of: </h4>
				<ol id="About_Us_List">
					<li> Jacob Baum </li>
					<li> Melvin Laubstein </li>
					<li> Tovel Bowie </li>
					<li> Murilo Delgado </li>
					<li> Jonathan Sienkiewicz </li>
					<li> Zaid Eliyas </li>
				</ol>
		</div>
	</body>
</html>
