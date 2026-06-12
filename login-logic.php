<?php

require_once('files/functions.php');

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if(login_user($email,$password)){
    alert('success','Logged in succesfully.');
    header('Location: account-orders.php');
}else{
    alert('danger','Incorrect username or password.');
    header('Location: login.php');
    die();
}


