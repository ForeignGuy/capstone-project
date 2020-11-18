<?php 
	session_start();
	$connection = mysqli_connect("localhost", "root", "", "Marv_Related_Information");
?>

<html>
	<head> 
		<title> About Marv </title>
		<title> Registration </title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="CSS/Main.css">
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
			<h3> Welcome to the Administration Menu! You can use the buttons below to view the tables for either users or the dataset. </h3>
			<form id="Admin_Menu_Tables" method="POST" action="">
				<button id="Admin_View_Users" name="Admin_View_Users"> View Users </button> <button id="Admin_View_Dataset" name="Admin_View_Dataset"> View Dataset </button>
			</form>
        </div>
		
		<?php 
			if (isset($_POST['Admin_View_Users'])) {
				$ViewUserTableInDatabase = mysqli_query($connection, "SELECT * FROM `users` INNER JOIN `user_account_type` on users.User_Number = user_account_type.Users_User_Number");
				echo "<form id='User_Table_Form' method='POST' action=''>";
				echo "<table id='User_Table' cellspacing='0'>";
				echo "<tr> <th> User Number </th> <th> Username </th> <th> Account Type </th> <th> Email Address </th> <th> Phone Number </th> </tr>";
				
				while ($TableData = mysqli_fetch_assoc($ViewUserTableInDatabase)) {
					echo "<tr> <td>" . $TableData['User_Number'] . "</td> <td>" . $TableData['Username'] . "</td> <td>" . $TableData['Admin_Account'] ."</td> <td>" . $TableData['Email_Address'] . "</td> <td>" . $TableData['Phone_Number'] . "</td> </tr>";
				}
				
				echo "</table>";
				echo "</form>";	
			}
	
			if (isset($_POST['Admin_View_Dataset'])) {
				$ViewDatasetTableInDatabase = mysqli_query($connection, "SELECT * FROM `dataset`");
				echo "<form id='Dataset_Table_Form' method='POST' action=''>";
				echo "<div id='Dataset_Search_Div'>"; 
					echo "<h3> Use this box to search the table based on an article's article number. </h3>";
					echo "<label for='Dataset_Search_By_Number'> Search By Number: </label> <input type='text' id='Dataset_Search_By_Number' name='Dataset_Search_By_Number' value=''> </input> <button id='Data_Search_By_Number_Button' name='Data_Search_By_Number_Button' value='Data_Search_By_Number_Button'> Search Dataset By Number </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's content/its text. </h3>";
					echo "<label for='Dataset_Search_By_Text'> Search By Text: </label> <input type='text' id='Dataset_Search_By_Text' name='Dataset_Search_By_Text' value=''> </input> <button id='Search_Dataset_By_Text_Button' name='Search_Dataset_By_Text_Button' value='Search_Dataset_By_Text_Button'> Search Dataset By Text </button>"; 
					echo "<br><br>";
					echo "<h3> Use this box to search the table based on an article's label, be it fake or real. </h3>";
					echo "<label for='Dataset_Search_By_Label'> Search By Label: </label> <input type='text' id='Dataset_Search_By_Label' name='Dataset_Search_By_Label' value=''> </input> <button id='Data_Search_By_Label_Button' name='Data_Search_By_Label_Button' value='Search_Dataset_By_Label_Button'> Search Dataset By Label </button>"; 
					
					echo "<br><br><br><br><br>";
					
					echo "<h3> Use this box to add new articles to the dataset. </h3>";
					echo "<label for='Add_Text'> News Article Text To Add: </label> <input type='text' id='Add_Text' name='Add_Text' value=''> </input>
					<label for='Add_Label'> News Article Label (REAL or FAKE): </label> <input type='text' id='Add_Label' name='Add_Label' value=''> </input> <br>
					<button id='Add_To_Dataset_Button' name='Add_To_Dataset_Button' value='Add_To_Dataset_Button'> Add Article To Database </button>"; 
					
					echo "<br><br><br><br><br>";
					
					echo "<h3> Use this box to delete entries from the database. </h3>";
					echo "<label for='Dataset_Delete_News'> Article Number for Deletion: </label> <input type='text' id='Dataset_Delete_News' name='Dataset_Delete_News' value=''> </input> <button id='Dataset_Delete_News_Button' name='Dataset_Delete_News_Button' value='Dataset_Delete_News_Button'> Delete Article With This Number </button>"; 
					echo "<br><br><br><br><br>";
					
				echo "</div>";
				echo "<br><br><br>";
				echo "<table class='Dataset_Table' cellspacing='0'>";
				echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
				$counter = 0;
				while (($TableData2 = mysqli_fetch_assoc($ViewDatasetTableInDatabase)) && $counter < 20) {
					echo "<tr> <td>" . $TableData2['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $TableData2['News_Text'] . "</td> <td>" . $TableData2['label'] ."</td> </tr>";
					$counter+=1;
				}
				
				echo "</table>";
				echo "</form>";	
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

	if (isset($_POST['Data_Search_By_Number_Button'])) {
		$SearchByNumberQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE News_Article_Number = '$ArticleNumberSearch'");
		echo "<table class='Dataset_Table' cellspacing='0'>";
				echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";			
				while ($NumberQueryData = mysqli_fetch_assoc($SearchByNumberQuery)) {
					echo "<tr> <td>" . $NumberQueryData['News_Article_Number'] . "</td> <td id='One_Result_Td'>" . $NumberQueryData['News_Text'] . "</td> <td>" . $NumberQueryData['label'] ."</td> </tr>";
				}
				echo "</table>";
				echo "</form>";	
	}
	
	if (isset($_POST['Search_Dataset_By_Text_Button'])) {
		$AppendedSearchText = "%" . $ArticleText . "%";
		$SearchByNumberQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE (News_Text = '$ArticleText') OR News_Text LIKE '$AppendedSearchText'");
		echo "<table class='Dataset_Table' cellspacing='0'>";
		echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
		$counter = 0;			
		while (($TextQueryData = mysqli_fetch_assoc($SearchByNumberQuery)) && $counter < 100) {
			echo "<tr> <td>" . $TextQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $TextQueryData['News_Text'] . "</td> <td>" . $TextQueryData['label'] ."</td> </tr>";
			$counter+=1;	
		}
		echo "</table>";
		echo "</form>";	
	}
	
	if (isset($_POST['Data_Search_By_Label_Button'])) {
		$SearchByLabelQuery = mysqli_query($connection, "SELECT * FROM `dataset` WHERE label='$ArticleLabel'");
		echo "<table class='Dataset_Table' cellspacing='0'>";
		echo "<tr> <th> News Article Number </th> <th> News Text </th> <th> News Label </th> </tr>";
		$counter = 0;			
		while (($LabelQueryData = mysqli_fetch_assoc($SearchByLabelQuery)) && $counter < 100) {
			echo "<tr> <td>" . $LabelQueryData['News_Article_Number'] . "</td> <td class='Regular_Text_Td'>" . $LabelQueryData['News_Text'] . "</td> <td>" . $LabelQueryData['label'] ."</td> </tr>";
			$counter+=1;	
		}
		echo "</table>";
		echo "</form>";	
	}
	
	if (isset($_POST['Add_To_Dataset_Button'])) {
		 mysqli_query($connection, "INSERT INTO `dataset` (News_Text, label) VALUES ('$NewText', '$NewLabel')");
		echo '<script type="text/javascript"> alert("That article has been added to the database!"); </script>';
	}
		
	if (isset($_POST['Dataset_Delete_News_Button'])) {
		$DeletionDatasetQuery = mysqli_query($connection, "DELETE FROM `dataset` WHERE News_Article_Number='$ArticleNumberDelete'");
		echo '<script type="text/javascript"> alert("That article has been removed from the database!"); </script>';
	}
		?>
	</body>
</html>
