<?php
$xmlDoc=new DOMDocument();
$xmlDoc->load("linksFAQ.xml");

$x=$xmlDoc->getElementsByTagName('link');

//get the q parameter from URL
$q=$_GET["q"];
$compteur=0;
//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $hint="";
  for($i=0; $i<($x->length) && $compteur<5 ; $i++) {
    $y=$x->item($i)->getElementsByTagName('title');
    $z=$x->item($i)->getElementsByTagName('faq');
    if ($y->item(0)->nodeType==1) {
      //find a link matching the search text
      if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$q)) {
        $compteur++;
          $hint=$hint . "<br /><p onclick=\"newMessageSearched(this)\">" . 
          $z->item(0)->childNodes->item(0)->nodeValue ."</p>";


      }
    }
  }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint=="") {
  $response="no suggestion";
} else {
  $response=$hint;
}

//output the response
echo $response;
?>