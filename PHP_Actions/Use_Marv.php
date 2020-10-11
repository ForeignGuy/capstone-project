<?php 
$command = escapeshellcmd('Test.py');
$output = shell_exec($command);
echo $output;
?>