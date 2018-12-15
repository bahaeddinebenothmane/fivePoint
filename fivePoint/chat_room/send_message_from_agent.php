<?php
session_start();
 require_once 'init.php';

//session_destroy();
//unset($_SESSION['partner'];//[$key]);
$id_discussion=$_GET["id_disscussion"];
$message=$_GET["q"];

$sql_insert="INSERT INTO message (contenu,id_discussion,type,datee) values (\"".$message."\",".$id_discussion.",\"replies\",\"".date('Y-m-d H:i:s')."\")";

	if ($db->query($sql_insert) === TRUE) {
    }
?>