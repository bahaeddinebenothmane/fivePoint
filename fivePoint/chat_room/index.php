<?php
session_start();
$_SESSION["agent"]=$_GET["id"];
require_once("init.php"); 
?>
<!DOCTYPE html>
<html class=''>
<head>

	<meta charset='UTF-8'>
	<meta name="robots" content="noindex">
	<link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />
	<link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
	<link rel="canonical" href="https://codepen.io/emilcarlsson/pen/ZOQZaV?limit=all&page=74&q=contact+" />
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="https://use.typekit.net/hoy3lrg.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
	<link rel="stylesheet" type="text/css" href="css.css">
	<style class="cp-pen-styles" >
	</style>

	<script >
		var current_agent=<?=$_SESSION["agent"]?>;
	</script>
</head>
<body>

<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
				<img id="profile-img" src="http://emilcarlsson.se/assets/mikeross.png" class="offline" alt="" />
				<p>YOU</p>
				<i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
				<div id="status-options">
					<ul>
						<li id="status-online" onclick="timer()" class="active"><span class="status-circle"></span> <p>Online</p></li>
						<li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
						<li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
						<li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
					</ul>
				</div>
				<div id="expanded">
					<input onkeyup="showProduct(this.value)" name="twitter" type="text"  placeholder="search for products" />
					<div id="livesearch_product" ></div>
					<input onkeyup="showFAQ(this.value)" name="twitter" type="text" placeholder="search for suggestions" />
					<div id="livesearch_FAQ"></div>
				</div>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" placeholder="Search contacts..." />
		</div>
		<div id="contacts" >
			<ul id="disscussion_list">
				<?php
					$sql = "SELECT   * FROM disscussion WHERE client=".$_SESSION["agent"]." or agent=".$_SESSION["agent"]; 
					$sqlnbr="SELECT   count(*) as nbr FROM disscussion WHERE client=".$_SESSION["agent"]." or agent=".$_SESSION["agent"];  
					$querynbr=$db->query($sqlnbr);
					$resultnbr= mysqli_fetch_assoc($querynbr);
					$query = $db->query($sql);
					while($result = mysqli_fetch_assoc($query)) :?>
						<li id="disscussion_<?=$result["id"]?>" class="contact" onclick="afficher_disscussion(<?=$result["id"]?>,<?=$resultnbr["nbr"]?>)"> 
							<?php
								$am_i_the_client=false;
								if($result["client"]==$_SESSION["agent"])
									$am_i_the_sender=true;
								$sql2 = "SELECT * FROM message WHERE id_discussion=".$result["id"]." order by id desc limit 1";
								$query2 = $db->query($sql2);
								$result2 = mysqli_fetch_assoc($query2);
								$style="";
								if($result2["type"]=="sent" && !$am_i_the_client)
									$style="style=\"color: red\"";
							?>
							<div class="wrap" <?=$style?>  >
								<span class="contact-status online"></span>
								<img src="<?=$result["image"]?>" alt="" />
								<div class="meta">
									<p class="name"><?=$result2["datee"]?></p>
									
									<p class="preview"><?=$result2["contenu"]?></p>
								</div>
							</div>
						</li>
				<?php
					endwhile;
				?>
			</ul>

			<?php
				$sql = "SELECT   * FROM disscussion WHERE agent=".$_SESSION["agent"]; 
				$query = $db->query($sql);
				while($result = mysqli_fetch_assoc($query)) :
			?>
			<ul id="suggestion_list_for_disscussion<?=$result["id"]?>" class="suggestion_list" style="display: none">
				<?php 
				$sql_last_message = "SELECT  * FROM message WHERE type=\"sent\" and id_discussion=".$result["id"]." order by id desc limit 1"; 
				$query_last_message = $db->query($sql_last_message);
				$result_last_message = mysqli_fetch_assoc($query_last_message);
				$last_message=$result_last_message["contenu"];
				if(strlen($last_message)>1){
					$msg=explode(" ", $last_message);
					$key="keywords like '%".$msg[0]."%' ";
					for ($i=1; $i <count($msg) ; $i++) { 
						$key.="or keywords like '%".$msg[$i]."%' ";
					}
					$sql_ds = "SELECT question,answer FROM `q&a` where $key";
					$query_ds = $db->query($sql_ds);
					while($result_ds = mysqli_fetch_assoc($query_ds)): 

				?>
						<li id="disscussion_jj" class="contact hint" style="overflow:scroll;"> 
							<div class="wrap"  >
								<span class="contact-status online"></span>
								<img src="geant.png" alt="" />
								<div class="meta" >
									<p class="name" onclick="newMessageSearched(this)">
										<?=$result_ds["question"]?>--<?=$result_ds["answer"]?>
									</p>
									
								</div>
							</div>
						</li>
				<?php endwhile;
				}
				?>			

			</ul>
			<?php endwhile;?>
		</div>

		<div id="bottom-bar">
			<button id="addcontact"  onclick="show_disscussions()"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>discusion</span></button>
			<button id="settings" onclick="show_tools(current_disscussion)"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>tools</span></button>
		</div>
	</div>
	<?php
		
		$sql_ds = "SELECT * FROM disscussion where agent=1";
		$query_ds = $db->query($sql_ds);
		while($result_ds = mysqli_fetch_assoc($query_ds)): ?>
			
	<div id="messages_discusion_<?=$result_ds["id"]?>" class="content" style="display: none">
		<div class="contact-profile">
			<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
			<p>Harvey Specter</p>
			<div class="social-media">
				<i class="fa fa-facebook" aria-hidden="true"></i>
				<i class="fa fa-twitter" aria-hidden="true"></i>
				 <i class="fa fa-instagram" aria-hidden="true"></i>
			</div>
		</div>
		<div id="message_list_<?=$result_ds["id"]?>" class="messages">

			<ul>	
				<?php
					$sql_msg = "SELECT * FROM message where id_discussion=".$result_ds["id"];
					$query_msg = $db->query($sql_msg);
					while($result_msg = mysqli_fetch_assoc($query_msg)): 
				?>
				<?php 

				if( $result_msg["type"]=="sent" && !$am_i_the_client )
					$type_result="sent";
				else
					$type_result="replies";

				?>
				<li class="<?=$type_result?>">
					<img src="<?=$result_ds["image"]?>" alt="" />
					<p><?=$result_msg["contenu"]?></p>
				</li>
				<?php
	    			endwhile;
				?>
			</ul>
		</div>
	    
		<div class="message-input">
			<div class="wrap">
			<input id="message_input_<?=$result_ds["id"]?>" type="text" placeholder="Write your message..." />
			<i class="fa fa-paperclip attachment" aria-hidden="true"></i>
			<button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
	<?php
	    endwhile;
	?>
</div>

<script src="js.js" >
	//# sourceURL=pen.js
</script>
<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>


</body>
</html>