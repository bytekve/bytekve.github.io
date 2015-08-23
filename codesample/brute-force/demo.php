<?php
  if(isset($_POST['email']) | isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    if($email == 'test@demo.brute' && $password == 'demo123'){
      echo "You are talent LOLLLL";
    } else{
      echo "Foo";
    }
  }
?>
<form method='POST'>
  <input type='text' name='email'>
  <input type='password' name='password'>
  <input type='submit' value='Login'>
</form>