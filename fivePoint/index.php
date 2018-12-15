<?php
session_start();
print_r($_SESSION);
if(isset($_SESSION['email'])){
	header('Location: chat_room');
	exit;
}
else{

	header('Location: login/login.php');
	exit;
}
?>