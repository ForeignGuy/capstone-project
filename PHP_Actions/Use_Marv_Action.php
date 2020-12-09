<?php
	$UserInput = $_POST['Headline'];
    $command = escapeshellcmd("MarvFinal.py ; C:\Users\Jacob Baum\anaconda3\bin\python -V 2>&1 $UserInput");
    $output = shell_exec($command);
    echo $output;
?>