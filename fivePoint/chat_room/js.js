
var current_disscussion=0;
var last_message_id=0;

$(".messages").animate({ scrollTop: $(document).height() }, "fast");

$("#profile-img").click(function() {
	$("#status-options").toggleClass("active");
});

$(".expand-button").click(function() {
  $("#profile").toggleClass("expanded");
	$("#contacts").toggleClass("expanded");
});

$("#status-options ul li").click(function() {
	$("#profile-img").removeClass();
	$("#status-online").removeClass("active");
	$("#status-away").removeClass("active");
	$("#status-busy").removeClass("active");
	$("#status-offline").removeClass("active");
	$(this).addClass("active");
	
	if($("#status-online").hasClass("active")) {
		$("#profile-img").addClass("online");
	} else if ($("#status-away").hasClass("active")) {
		$("#profile-img").addClass("away");
	} else if ($("#status-busy").hasClass("active")) {
		$("#profile-img").addClass("busy");
	} else if ($("#status-offline").hasClass("active")) {
		$("#profile-img").addClass("offline");
	} else {
		$("#profile-img").removeClass();
	};
	
	$("#status-options").removeClass("active");
});

function newMessage() {
	message = $("#message_input_"+current_disscussion).val();
	if($.trim(message) == '') {
		return false;
	}
	$('<li class="replies"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('#message_list_'+current_disscussion+' ul'));
	$('.message-input input').val(null);
	$('.contact.active .preview').html('<span>You: </span>' + message);
	$(".messages").animate({ scrollTop: $(document).height() }, "fast");

	sen_to_server(message,current_disscussion);
}
function newMessageSearched(a) {
	message = a.innerHTML;
	if($.trim(message) == '') {
		return false;
	}
	$('<li class="replies"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('#message_list_'+current_disscussion+' ul'));
	$('.message-input input').val(null);
	$('.contact.active .preview').html('<span>You: </span>' + message);
	$(".messages").animate({ scrollTop: $(document).height() }, "fast");
	sen_to_server(message,current_disscussion);

}


$('.submit').click(function() {

  newMessage();
});

$(window).on('keydown', function(e) {
  if (e.which == 13) {
     newMessage();
    return false;
  }
});
	function afficher_meesage(messageid,disscussion_count){
		for(var i = 1; i <= disscussion_count; i++)
		{
			document.getElementById("messages_discusion_"+i).style.display = "none";
		}
		  document.getElementById("messages_discusion_"+messageid).style.display = "";
		
	}
	function show_disscussions()
	{

			var l11=document.getElementById("disscussion_list");
			$('.suggestion_list').css("display", "none");
			l11.style.display = "block";
	}
	function show_tools(currnt_disscuss)
	{
			var l11=document.getElementById("disscussion_list");

			$('.suggestion_list').css("display", "none");
			var l22=document.getElementById("suggestion_list_for_disscussion"+currnt_disscuss);
			l22.style.display = "block";
			l11.style.display = "none"
			

	}

	function afficher_disscussion(id,disscussion_count){
			var li=document.getElementById("disscussion_"+id);
			current_disscussion=id;
			for (var i = 1; i <= disscussion_count; i++) {
				var li1=document.getElementById("disscussion_"+i);
				li1.classList.remove('active');
			}
			li.classList.add("active");
			var messageid =id;
			afficher_meesage(messageid,disscussion_count);

		}

	function showFAQ(str) {
	  if (str.length<2) { 
	    document.getElementById("livesearch_FAQ").innerHTML="";
	    document.getElementById("livesearch_FAQ").style.border="0px";
	    return;
	  }
	  else{
	    document.getElementById("livesearch_FAQ").innerHTML="chargement...";
	    if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200) {
	      document.getElementById("livesearch_FAQ").innerHTML=this.responseText;
	      document.getElementById("livesearch_FAQ").style.border="1px solid #A5ACB2";
	    }
	  }
	  xmlhttp.open("GET","livesearch_FAQ.php?q="+str,true);
	  xmlhttp.send();
	  }  
	}


	function showProduct(str) {
	  if (str.length<2) { 
	    document.getElementById("livesearch_product").innerHTML="";
	    document.getElementById("livesearch_product").style.border="0px";
	    return;
	  }
	  else{
	    document.getElementById("livesearch_product").innerHTML="chargement...";
	    if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200) {
	      document.getElementById("livesearch_product").innerHTML=this.responseText;
	      document.getElementById("livesearch_product").style.border="1px solid #A5ACB2";
	    }
	  }
	  xmlhttp.open("GET","livesearch_Product.php?q="+str,true);
	  xmlhttp.send();

	  }  
	}
	function sen_to_server(msg,id_diss){
		
	    if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }

	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200) {
	    	//display_msg(this.responseText,0);
	        //document.getElementById("livesearch").innerHTML=this.responseText;
	        //document.getElementById("livesearch").style.border="1px solid #A5ACB2";
	    }
	  }
	  xmlhttp.open("GET","send_message_from_agent.php?q="+msg+"&id_disscussion="+id_diss,true);
	  xmlhttp.send();

	  //return;
	  
	}

	function timer(){

	    if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200) {
	    	alert(last_message_id);
	    	/*
	    	display_msg_history(this.responseText,0);
	    	if(this.responseText.length>1){
	    		bring_response_checking_counter=0;
				clearTimeout(myVar);
	    	}
	    	*/
	    }
	  }
	  xmlhttp.open("GET","is_there_a_message.php?last_message_id="+last_message_id+"&agent_id="+current_agent,true);
	  xmlhttp.send();

	  //return;
	  
	}
