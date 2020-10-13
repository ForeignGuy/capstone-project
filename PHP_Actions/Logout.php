<?php
	session_start();
	session_destroy();
	header("Location: ../Homepage.php");
?>