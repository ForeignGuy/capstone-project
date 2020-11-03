<?php 
    $dog = "Dog";
    $command = escapeshellcmd("MarvTest.py $dog");
    $output = shell_exec($command);
    echo $output;
?>