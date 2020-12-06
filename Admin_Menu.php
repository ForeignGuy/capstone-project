<?php 
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "Marv_Related_Information");
?>

<html>
	<head> 
		<title> Admin Menu </title>
		<meta charset="utf-8">
		<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet" />
		<link href="./css/blk-design-system.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
	</head>
	
	<body>
		<div id="Welcome_Bar"> <br>
			<span id="Greetings" class="Center"> <h1> Welcome to Marv<?php if (isset($_SESSION['Username'])) { echo ", "; echo $_SESSION['Username'];  echo "!"; }?> </h1></span>
			<span class="Welcome_Item"> <a href="Homepage.php"> Homepage </a> </span> 
            <span class="Welcome_Item"> <a href="About_Marv.php"> About Marv </a> </span>
			<span class="Welcome_Item"> <a href="About_Us.php"> About Us </a> </span> 
			<span class="Welcome_Item"> <a href="Use_Marv.php"> Use Marv </a> </span> 
			<span Id="Final_Welcome_Item"> <a href="Contact_Us.php"> Contact Us </a> </span>
			<br> <span id='Admin_Menu_Link'> <a href='Admin_Menu.php'> Admin Menu </a> </span>
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

						<input type='submit' id='Login' class='Login_And_Register_Buttons' name='Login' value='Login'>
					</form>
					
					<form>
						<button id='Register_Button' class='Login_And_Register_Buttons' name='Register_Button' value='Register'> <a href='Marv_Reg.php'>  Register  </a> </button>
						<div id='Reset_Password_Link'> <a href='Reset_Password.php'> <b> <u> I Forgot My Password </u> </b> </a> </div>
					</form>";
					
				} else {
					echo "<div class='Login_Or_Logout_Area Float_Right'>
							<form id='Logout_Form' class='Float_Right' method='POST' action='PHP_Actions/Logout.php'> 
								<h4 id='Logout_Title'> Log Out </h4>
								<br><br><br><br><br>
								<input type='submit' id='Logout_Button' name='Logout' value='Log Out'>
							</form>";
				} 
			?>
		</div>
		
		<br><br>
        
		<div align='center'>
			<h3> Welcome to the Administration Menu! You can use the buttons below to view the tables for either users or the dataset. </h3>
			<form id="Admin_Menu_Tables" method="POST" action="">
				<button id="Admin_View_Users" name="Admin_View_Users"> View Users </button> <button id="Admin_View_Dataset" name="Admin_View_Dataset"> View Dataset </button>
			</form>
        </div>
		

	<?php 
		if (isset($_POST['Delete_User'])) {
			$DeleteUser = $_POST['Delete_User'];
		} else {
			$DeleteUser = null;
		}
		
		if (isset($_POST['Dataset_Search_By_Number'])) {
		$ArticleNumberSearch = $_POST['Dataset_Search_By_Number'];
		} else {
			$ArticleNumberSearch = null;
		}
		
		if (isset($_POST['Dataset_Search_By_Text'])) {
			$ArticleText = $_POST['Dataset_Search_By_Text'];
		} else {
			$ArticleText = null;
		}
		
		if (isset($_POST['Dataset_Search_By_Label'])) {
			$ArticleLabel = $_POST['Dataset_Search_By_Label'];
		} else {
			$ArticleLabel = null;
		}
		
		if (isset($_POST['Dataset_Delete_News'])) {
			$ArticleNumberDelete = $_POST['Dataset_Delete_News'];
		} else {
			$ArticleNumberDelete = null;
		}
		
		if (isset($_POST['Add_Text'])) {
			$NewText = $_POST['Add_Text'];
		} else {
			$NewText = null;
		}
	
		if (isset($_POST['Add_Label'])) {
			$NewLabel = $_POST['Add_Label'];			
		} else {
			$NewLabel = null;
		}
		
		if (isset($_POST['Admin_View_Users'])) {
			$ViewUserTableInDatabase = mysqli_query($connection, "SELECT * FROM `users` INNER JOIN `user_account_type` on users.User_Number = user_account_type.Users_User_Number");
			echo "<form id='User_Table_Form' method='POST' action=''>";
				echo "<br>";
				echo "<div id='Users_Div'>";
				echo "<p id='User_Input_Label'> Delete User Based on User Number: </p> <input type='text' id='Delete_User' name='Delete_User' value=''> </input> <button id='Delete_User_Button' name='Delete_User_Button' value='Delete This User'> Delete This User </button>"; 
					echo "<br><br><br>";
				echo "</div>";
				echo "<h3 id='User_Table_Title' class='Center'> Users Table </h3>";
				echo "<table id='User_Table' cellspacing='0'>";
					echo "<tr> <th> User Number </th> <th> Username </th> <th> Account Type </th> <th> Email Address </th> <th> Phone Number </th> </tr>";
				
					while ($TableData = mysqli_fetch_assoc($ViewUserTableInDatabase)) {
						echo "<tr> <td>" . $TableData['User_Number'] . "</td> <td>" . $TableData['Username'] . "</td> <td>" . $TableData['Admin_Account'] ."</td> <td>" . $TableData['Email_Address'] . "</td> <td>" . $TableData['Phone_Number'] . "</td> </tr>";
					}
				
				echo "</table>";
			echo "</form>";	
		}
		
		if (isset($_POST['Delete_User_Button'])) {
			mysqli_query($connection, "DELETE FROM `users` WHERE User_Number='$DeleteUser'");
		}
		
		/** MAIN TABLE START **/
		
		if (isset($_POST['Admin_View_Dataset'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>"; 
					
					echo "<br><br>";
					
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
		
				echo "</div>";
			echo "</form>";
			echo "<br>";			
					
			echo "<h3 class='Center'> Dataset Table </h3>";
			echo "<table id='Dataset_Table_Main' cellspacing='0'>";
			echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
			$ViewDatasetTableInDatabase = mysqli_query($connection, "SELECT * FROM `dataset` LIMIT 51");	
			while ($TableData2 = mysqli_fetch_assoc($ViewDatasetTableInDatabase)) {
				echo "<tr> <td>" . $TableData2['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $TableData2['News_Text'] . "</td> <td>" . $TableData2['label'] ."</td> </tr>";
			}
			
			echo "</table>";		
			echo "<br><br>";

			echo "<form method='POST' action=''>";
				echo "<button id='Show_Next_50_Main' name='Show_Next_50_Main' value='Show_Next_50_Main'> Show Next 50 Results </button>";
			echo "</form>";

			$_SESSION['Counter'] = 0;			
		}
		
		// Next 50 Results
		
		if (isset($_POST['Show_Next_50_Main'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>"; 
					
					echo "<br><br>";
					
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
					echo "<br><br><br><br><br>";
				echo "</div>";
			echo "</form>";	
					
			$CheckTableData = mysqli_query($connection, "SELECT * FROM `dataset`");
			$Next50Main = mysqli_query($connection, "SELECT * FROM `dataset` LIMIT 51 OFFSET " . ($_SESSION['Counter'] + 50) . "");
			if ($_SESSION['Counter'] <= mysqli_num_rows($CheckTableData) AND mysqli_fetch_assoc($Next50Main)) {
				echo "<h3 class='Center'> Dataset Table </h3>";
				echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<table class='Dataset_Table_Main2' cellspacing='0'>";
					echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";			
					while ($Next50SetMain = mysqli_fetch_assoc($Next50Main)) {
						echo "<tr> <td>" . $Next50SetMain['News_Article_Number'] . "</td> <td id='One_Result_Td'>" . $Next50SetMain['News_Text'] . "</td> <td>" . $Next50SetMain['label'] ."</td> </tr>";
					}
				
				echo "</table>";
				echo "<br><br>";
				
				echo "<form method='POST' action=''>";
					echo "<button id='Show_Next_50_Main' name='Show_Next_50_Main' value='Show_Next_50_Main'> Show Next 50 Results </button>";
					echo "<button id='Show_Last_50_Main' name='Show_Last_50_Main' value='Show_Last_50_Main'> Show Previous 50 Results </button>";
				echo "</form>";
				
				} else {
					echo "<form method='POST' action=''>";
						echo "<h1 class='No_Results'> No results to show. </h1>";
						echo "<button id='Special_Show_Last' name='Show_Last_50_Main' value='Show_Last_50_Main'> Show Previous 50 Results </button>";
					echo "</form>";
				}		
		
				$_SESSION['Counter'] = $_SESSION['Counter'] + 50;					
			}
		
		// Show Previous 50 Results
		
		if (isset($_POST['Show_Last_50_Main'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>";
					echo "<br><br>";
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
					echo "<br><br><br><br><br>";
				echo "</div>";
			echo "</form>";	
					
			$_SESSION['Counter'] = $_SESSION['Counter'] - 50;
		
			$Next50Main = mysqli_query($connection, "SELECT * FROM `dataset` LIMIT 51 OFFSET " . $_SESSION['Counter'] . "");
			
			if ($_SESSION['Counter'] >= 50 AND mysqli_fetch_assoc($Next50Main)) {
				echo "<h3 class='Center'> Dataset Table </h3>";
				echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<table class='Dataset_Table_Main2' cellspacing='0'>";
					echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";			
					while ($Next50SetMain = mysqli_fetch_assoc($Next50Main)) {
						echo "<tr> <td>" . $Next50SetMain['News_Article_Number'] . "</td> <td id='One_Result_Td'>" . $Next50SetMain['News_Text'] . "</td> <td>" . $Next50SetMain['label'] ."</td> </tr>";
					}
				
				echo "</table>";
				
				echo "<form method='POST' action=''>";
					echo "<button id='Show_Next_50_Main' name='Show_Next_50_Main' value='Show_Next_50_Main'> Show Next 50 Results </button>";
					echo "<button id='Show_Last_50_Main' name='Show_Last_50_Main' value='Show_Last_50_Main'> Show Previous 50 Results </button>";
				echo "</form>";
				
				} else if ($_SESSION['Counter'] < 50) {
					echo "<h3 class='Center'> Dataset Table </h3>";
					echo "<table id='Dataset_Table_Main' cellspacing='0'>";
					echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
					$ViewDatasetTableInDatabase = mysqli_query($connection, "SELECT * FROM `dataset` LIMIT 51");	
					while ($TableData2 = mysqli_fetch_assoc($ViewDatasetTableInDatabase)) {
						echo "<tr> <td>" . $TableData2['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $TableData2['News_Text'] . "</td> <td>" . $TableData2['label'] ."</td> </tr>";
					}
					
					echo "</table>";		
					echo "<br><br>";

					echo "<form method='POST' action=''>";
						echo "<button id='Show_Next_50_Main' name='Show_Next_50_Main' value='Show_Next_50_Main'> Show Next 50 Results </button>";
					echo "</form>";

					$_SESSION['Counter'] = 0;		
				} else {
					echo "<form method='POST' action=''>";
						echo "<h1 class='No_Results'> No results to show. </h1>";
						echo "<button id='Special_Show_Next' name='Show_Next_50_Main' value='Show_Next_50_Main'> Show Next 50 Results </button>";
					echo "</form>";
				}
			}
		
		/** MAIN TABLE END **/
		
		// Search by number
		if (isset($_POST['Dataset_Search_By_Number_Button'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>";
					echo "<br><br>";echo "<br><br>";
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
				echo "</div>";
			echo "</form>";
			echo "<br><br>";
			
			$SearchByNumberQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE News_Article_Number = '$ArticleNumberSearch'");
			
			if (mysqli_num_rows($SearchByNumberQuery) >= 1) {
				echo "<h3 class='Center'> Dataset Table </h3>";
				echo "<table id='Dataset_Table_Number' cellspacing='0'>";
					echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
					while ($NumberQueryData = mysqli_fetch_assoc($SearchByNumberQuery)) {
						echo "<tr> <td>" . $NumberQueryData['News_Article_Number'] . "</td> <td id='One_Result_Td'>" . $NumberQueryData['News_Text'] . "</td> <td>" . $NumberQueryData['label'] ."</td> </tr>";
					}
				echo "</table>";
			} else {
				echo "<h1 class='No_Results'> No results to show. </h1>";
			}
		}
		
		/** SEARCH BY TEXT START **/
		
		if (isset($_POST['Dataset_Search_By_Text_Button'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>";
					echo "<br><br>";
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
				echo "</div>";
			echo "</form>";
					
			echo "<br>";
		
			$AppendedSearchText = "%" . $ArticleText . "%";
			$SearchByTextQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE (News_Text = '$ArticleText') OR News_Text LIKE '$AppendedSearchText' LIMIT 51");
			$_SESSION['ArticleTextSearch'] = $AppendedSearchText;
			
			if (mysqli_fetch_assoc($SearchByTextQuery)) {
					$AppendedSearchText = $_SESSION['ArticleTextSearch'];
					$SearchByTextQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE (News_Text = '$ArticleText') OR News_Text LIKE '$AppendedSearchText' LIMIT 51");
					echo "<h3 class='Center'> Dataset Table </h3>";
					echo "<table class='Dataset_Table_Text' cellspacing='0'>";
					echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";			
					while ($TextQueryData = mysqli_fetch_assoc($SearchByTextQuery)) {
						echo "<tr> <td>" . $TextQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $TextQueryData['News_Text'] . "</td> <td>" . $TextQueryData['label'] ."</td> </tr>";
					}
					
					echo "</table>";
					echo "<form method='POST' action=''>";
						echo "<button id='Show_Next_50_Text' name='Show_Next_50_Text' value='Show_Next_50_Text'> Show Next 50 Results </button>";
					echo "</form>";
			} else {
				echo "<form method='POST' action=''>";
					echo "<h1 class='No_Results'> No results to show. </h1>";
				echo "</form>";
			}
			
			$_SESSION['Counter'] = 0;	
		}
		
		// Next 50 results
		
		if (isset($_POST['Show_Next_50_Text'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>";
					echo "<br><br>";
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>";
				echo "</div>";
			echo "</form>";
			
			echo "<br><br><br><br><br>";
			
			$AppendedSearchText = $_SESSION['ArticleTextSearch'];
			$SearchByTextQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE (News_Text = '$ArticleText') OR News_Text LIKE '$AppendedSearchText' LIMIT 51 OFFSET " . ($_SESSION['Counter'] + 50) . "");
			
			if ($_SESSION['Counter'] <= (mysqli_num_rows($SearchByTextQuery)) AND mysqli_fetch_assoc($SearchByTextQuery)) {
				echo "<h3 class='Center'> Dataset Table </h3>";
				echo "<table class='Dataset_Table_Text2' cellspacing='0'>";
				echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";			
				while (($TextQueryData = mysqli_fetch_assoc($SearchByTextQuery))) {
					echo "<tr> <td>" . $TextQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $TextQueryData['News_Text'] . "</td> <td>" . $TextQueryData['label'] ."</td> </tr>";
				}
				
				echo "</table>";
				
				echo "<form method='POST' action=''>";
					echo "<button id='Show_Next_50_Text' name='Show_Next_50_Text' value='Show_Next_50_Text'> Show Next 50 Results </button>";
					echo "<button id='Show_Last_50_Text' name='Show_Last_50_Text' value='Show_Last_50_Text'> Show Previous 50 Results </button>";
				echo "</form>";
				
				} else {
					echo "<form method='POST' action=''>";
						echo "<h1 class='No_Results'> No results to show. </h1>";
						echo "<button id='Special_Show_Last' name='Show_Last_50_Text' value='Show_Last_50_Text'> Show Previous 50 Results </button>";
					echo "</form>";
				}	
		
				$_SESSION['Counter'] = $_SESSION['Counter'] + 50;	
		}
		
		// Last 50 results
		
		if (isset($_POST['Show_Last_50_Text'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>";
					echo "<br><br>";
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
				echo "</div>";
			echo "</form>";
					
			echo "<br>";
			
			$AppendedSearchText = $_SESSION['ArticleTextSearch'];
			$SearchByTextQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE (News_Text = '$ArticleText') OR News_Text LIKE '$AppendedSearchText' LIMIT 51 OFFSET " . ($_SESSION['Counter'] - 50) . "");
			
			if ($_SESSION['Counter'] > 50 AND mysqli_fetch_assoc($SearchByTextQuery)) {
				echo "<h3 class='Center'> Dataset Table </h3>";
				echo "<table class='Dataset_Table_Text2' cellspacing='0'>";
				echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";			
				while (($TextQueryData = mysqli_fetch_assoc($SearchByTextQuery))) {
					echo "<tr> <td>" . $TextQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $TextQueryData['News_Text'] . "</td> <td>" . $TextQueryData['label'] ."</td> </tr>";
				}
					
				echo "</table>";
				
				echo "<form method='POST' action=''>";
					echo "<button id='Show_Next_50_Text' name='Show_Next_50_Text' value='Show_Next_50_Text'> Show Next 50 Results </button>";
					echo "<button id='Show_Last_50_Text' name='Show_Last_50_Text' value='Show_Last_50_Text'> Show Previous 50 Results </button>";
				echo "</form>";
				
				} else if ($_SESSION['Counter'] <= 50) {
					$AppendedSearchText = $_SESSION['ArticleTextSearch'];
					$SearchByTextQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE (News_Text = '$ArticleText') OR News_Text LIKE '$AppendedSearchText' LIMIT 51");
					echo "<h3 class='Center'> Dataset Table </h3>";
					echo "<table class='Dataset_Table_Text' cellspacing='0'>";
					echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";			
					while ($TextQueryData = mysqli_fetch_assoc($SearchByTextQuery)) {
						echo "<tr> <td>" . $TextQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $TextQueryData['News_Text'] . "</td> <td>" . $TextQueryData['label'] ."</td> </tr>";
					}
					
					echo "</table>";
					echo "<form method='POST' action=''>";
						echo "<button id='Show_Next_50_Text' name='Show_Next_50_Text' value='Show_Next_50_Text'> Show Next 50 Results </button>";
					echo "</form>";
				} else {
					echo "<form method='POST' action=''>";
						echo "<h1 class='No_Results'> No results to show. </h1>";
						echo "<button id='Special_Show_Next' name='Show_Next_50_Text' value='Show_Next_50_Text'> Show Next 50 Results </button>";
					echo "</form>";
				}
				
				$_SESSION['Counter'] = $_SESSION['Counter'] - 50;
		}
		
		/** SEARCH BY TEXT END **/
		
		/** SEARCH BY LABEL START **/
		
		if (isset($_POST['Dataset_Search_By_Label_Real'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>";
					echo "<br><br>";
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
				echo "</div>";
			echo "</form>";
					
			echo "<br>";
			$_SESSION['Label'] = "REAL";
			$SearchByLabelQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE label='" . $_SESSION['Label'] . "' LIMIT 51");
			
			if (mysqli_fetch_assoc($SearchByLabelQuery)) {				
				$_SESSION['Label'] = "REAL";
				$SearchByLabelQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE label='" . $_SESSION['Label'] . "' LIMIT 51");
				echo "<h3 class='Center'> Dataset Table </h3>";
				echo "<table id='Dataset_Table_Label' cellspacing='0'>";
				echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
				while ($LabelQueryData = mysqli_fetch_assoc($SearchByLabelQuery)) {
					echo "<tr> <td>" . $LabelQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $LabelQueryData['News_Text'] . "</td> <td>" . $LabelQueryData['label'] ."</td> </tr>";
				}
				
				echo "</table>";
				
				echo "<form method='POST' action=''>";
					echo "<button id='Show_Next_50_Label' name='Show_Next_50_Label' value='Show_Next_50_Label'> Show Next 50 Results </button>";
				echo "</form>";
			} else {
				echo "<h1 class='No_Results'> No results to show. </h1>";
			}
			
			$_SESSION['Counter'] = 0;	
		}
		
		if (isset($_POST['Dataset_Search_By_Label_Fake'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>";
					echo "<br><br>";
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
					echo "</div>";
				echo "</form>";
						
				echo "<br><br><br><br><br>";
				$_SESSION['Label'] = "FAKE";
				$SearchByLabelQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE label='" . $_SESSION['Label'] . "' LIMIT 51");
				
				if (mysqli_fetch_assoc($SearchByLabelQuery)) {				
					$_SESSION['Label'] = "FAKE";
					$SearchByLabelQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE label='" . $_SESSION['Label'] . "' LIMIT 51");
					echo "<h3 class='Center'> Dataset Table </h3>";
					echo "<table id='Dataset_Table_Label' cellspacing='0'>";
					echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
					while ($LabelQueryData = mysqli_fetch_assoc($SearchByLabelQuery)) {
						echo "<tr> <td>" . $LabelQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $LabelQueryData['News_Text'] . "</td> <td>" . $LabelQueryData['label'] ."</td> </tr>";
					}
					
					echo "</table>";
					
					echo "<form method='POST' action=''>";
						echo "<button id='Show_Next_50_Label' name='Show_Next_50_Label' value='Show_Next_50_Label'> Show Next 50 Results </button>";
					echo "</form>";
				} else {
					echo "<h1 class='No_Results'> No results to show. </h1>";
				}
				
				$_SESSION['Counter'] = 0;	
			
			}
		
		// Next 50 Results
		
		if(isset($_POST['Show_Next_50_Label'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>";
					echo "<br><br>";
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
				echo "</div>";
			echo "</form>";
					
			echo "<br>";
			
			$SearchByLabelQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE label='" . $_SESSION['Label'] . "' LIMIT 51 OFFSET " . ($_SESSION['Counter'] + 50) . "");
			
			
			$CheckTableData = mysqli_query($connection, "SELECT * FROM `dataset` WHERE label='" . $_SESSION['Label'] . "'");
			$CheckTableData2 = mysqli_num_rows($CheckTableData);
			
			if ($_SESSION['Counter'] <= $CheckTableData2 AND mysqli_fetch_assoc($SearchByLabelQuery)) {
				echo "<h3 class='Center'> Dataset Table </h3>";
				echo "<table id='Dataset_Table_Label' cellspacing='0'>";
				echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
				while (($LabelQueryData = mysqli_fetch_assoc($SearchByLabelQuery))) {
					echo "<tr> <td>" . $LabelQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $LabelQueryData['News_Text'] . "</td> <td>" . $LabelQueryData['label'] ."</td> </tr>";
				}
				
				echo "</table>";
				
				echo "<form method='POST' action=''>";
					echo "<button id='Show_Next_50_Label' name='Show_Next_50_Label' value='Show_Next_50_Label'> Show Next 50 Results </button>";
					echo "<button id='Show_Last_50_Label' name='Show_Last_50_Label' value='Show_Last_50_Label'> Show Previous 50 Results </button>";
				echo "</form>";
			} else {
				echo "<form method='POST' action=''>";
					echo "<h1 class='No_Results'> No results to show. </h1>";
					echo "<button id='Special_Show_Last' name='Show_Last_50_Label' value='Show_Last_50_Label'> Show Previous 50 Results </button>";
				echo "</form>";
			}
			
			$_SESSION['Counter'] = $_SESSION['Counter'] + 50;	
		}
		
		// Last 50 Results
		
		if(isset($_POST['Show_Last_50_Label'])) {
			echo "<form class='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<p class='Number_Label'> Search By Number: </p> <input type='text' id='Dataset_Search_By_Number' class='Admin_Menu_Input_Box' name='Dataset_Search_By_Number' value=''> </input> <button id='Dataset_Search_By_Number_Button' name='Dataset_Search_By_Number_Button' value='Dataset_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<p class='Text_Label'> Search By Text: </p> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Dataset_Search_By_Text_Button' name='Dataset_Search_By_Text_Button' value='Dataset_Search_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<button class='Dataset_Search_By_Label_Real' name='Dataset_Search_By_Label_Real' value='REAL'> Search By True Results </button> <button class='Dataset_Search_By_Label_Fake' name='Dataset_Search_By_Label_Fake' value='FAKE'> Search By Fake Results </button>";
					echo "<br><br>";
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<p class='New_Article_Text'> News Article Text To Add: </p> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<p class='New_Article_Label'> News Article Label (REAL or FAKE): </p> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<p class='Delete_Label'> Article Number for Deletion: </p> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
				echo "</div>";
			echo "</form>";
					
			echo "<br>";
			
			$SearchByLabelQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE label='" . $_SESSION['Label'] . "' LIMIT 51 OFFSET " . ($_SESSION['Counter'] - 50) . "");
	
			if ($_SESSION['Counter'] >= 50 AND mysqli_fetch_assoc($SearchByLabelQuery)) {
				echo "<h3 class='Center'> Dataset Table </h3>";
				echo "<table id='Dataset_Table_Label' cellspacing='0'>";
				echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
				while (($LabelQueryData = mysqli_fetch_assoc($SearchByLabelQuery))) {
					echo "<tr> <td>" . $LabelQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $LabelQueryData['News_Text'] . "</td> <td>" . $LabelQueryData['label'] ."</td> </tr>";
				}
				
				echo "</table>";
				
				echo "<form method='POST' action=''>";
					echo "<button id='Show_Next_50_Label' name='Show_Next_50_Label' value='Show_Next_50_Label'> Show Next 50 Results </button>";
					echo "<button id='Show_Last_50_Label' name='Show_Last_50_Label' value='Show_Last_50_Label'> Show Previous 50 Results </button>";
				echo "</form>";
				
			} else if ($_SESSION['Counter'] > 0) {
				echo $_SESSION['Counter'];
				echo "<h3 class='Center'> Dataset Table </h3>";
				echo "<table id='Dataset_Table_Label' cellspacing='0'>";
				echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
				while ($LabelQueryData = mysqli_fetch_assoc($SearchByLabelQuery)) {
					echo "<tr> <td>" . $LabelQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $LabelQueryData['News_Text'] . "</td> <td>" . $LabelQueryData['label'] ."</td> </tr>";
				}
				
				echo "</table>";
				
				echo "<form method='POST' action=''>";
					echo "<button id='Show_Next_50_Label' name='Show_Next_50_Label' value='Show_Next_50_Label'> Show Next 50 Results </button>";
				echo "</form>";
			} else {
				echo "<form method='POST' action=''>";
					echo "<h1 class='No_Results'> No results to show. </h1>";
					echo "<button id='Special_Show_Next' name='Show_Next_50_Label' value='Show_Next_50_Label'> Show Next 50 Results </button>";
				echo "</form>";
			}
			
			$_SESSION['Counter'] = $_SESSION['Counter'] - 50;
		}
		
		/** SEARCH BY LABEL END **/
		
		// Add To Dataset
		
		if (isset($_POST['Add_To_Dataset_Button'])) {
			$NewLabel = $_POST['Add_Label'];
			$NewLabel = trim(strtoUpper($NewLabel)); 
			if ($NewLabel=="REAL") {
				$BertInt="1";
				mysqli_query($connection, "INSERT INTO `dataset` (News_Text, label, Bert_Int) VALUES ('$NewText', '$NewLabel','$BertInt')");
				echo '<script type="text/javascript"> alert("Your article has been successfully added to the database!"); </script>'; 	
			} else if ($NewLabel=="FAKE") {
				$BertInt="0";
				mysqli_query($connection, "INSERT INTO `dataset` (News_Text, label, Bert_Int) VALUES ('$NewText', '$NewLabel','$BertInt')");	
				echo '<script type="text/javascript"> alert("Your article has been successfully added to the database!"); </script>'; 				
			} else {
				echo '<script type="text/javascript"> alert("Your label, ' . $NewLabel . ', is not a real label. Use FAKE or REAL."); </script>'; 
			}
		}
		
		// Delete From Dataset
			
		if (isset($_POST['Dataset_Delete_News_Button'])) {
			$DeletionDatasetQuery = mysqli_query($connection, "DELETE FROM `dataset` WHERE News_Article_Number='$ArticleNumberDelete'");
			echo '<script type="text/javascript"> alert("That article, number ' . $ArticleNumberDelete . ', if it exists, has been removed from the database!"); </script>';
		}
	?>
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