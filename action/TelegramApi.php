<?php 

$botToken="1642307317:AAGhowf1mq1TTXKRzDIMM6DK_WF02K3oroc";
$chatId="1661722427";  

  $website="https://api.telegram.org/bot".$botToken;
  $params=[
      'chat_id'=>$chatId,
      'text'=>$name,
  ];
  $ch = curl_init($website . '/sendMessage');
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);
