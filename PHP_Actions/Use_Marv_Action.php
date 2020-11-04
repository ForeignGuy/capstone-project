<?php

    $Userinput=isset($_POST['Input_Headline']) ? $_POST['Input_Headline'] : "";
    $command = escapeshellcmd("MarvTest.py $Userinput");
    $output = shell_exec($command);
    echo $output;
?>
