<?php
	$UserInput = $_POST['Headline'];
    $command = escapeshellcmd("MarvTest.py $UserInput");
    $output = shell_exec($command);
    echo $output;
?>