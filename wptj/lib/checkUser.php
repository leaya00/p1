<?php
	session_start();
	if(empty($_SESSION['username'])){		
		echo "<script>location.href='../login.php';</script>"; 
		}