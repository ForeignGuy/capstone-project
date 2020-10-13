<?php 
$command = escapeshellcmd('MarvTest.py');
$output = shell_exec($command);
echo $output;
?>
