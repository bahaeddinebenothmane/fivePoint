<?php
	session_start();
	 require_once 'init.php';

	$sql="select message.* from message,disscussion  where disscussion.id=message.id_discussion and message.id>".$_GET["last_message_id"]." and disscussion.agent=".$_GET["agent_id"]; 
	$query = $db->query($sql);
	while ($result = mysqli_fetch_assoc($query)) {
    	echo $result["contenu"]."message_type".$result["type"]."next_message";
	}
?>