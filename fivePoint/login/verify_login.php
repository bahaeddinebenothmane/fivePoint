<?php
session_start();

 require_once 'init.php';

 $sql = "SELECT  count(*) nbr,id FROM client WHERE email=\"".$_POST["email"]."\" and password=\"".$_POST["password"]."\""; 
 echo $sql;
 $query = $db->query($sql);
 $result = mysqli_fetch_assoc($query);
 if($result["nbr"]==1){
 	 $_SESSION["email"]=$_POST["email"];
	 header("Location: ../chat_room/index.php?id=".$result["id"]);
	 die();
} 
else{
	header("Location: login.php?id=".$result["id"]);
	 die();

}	 
?>
              
    