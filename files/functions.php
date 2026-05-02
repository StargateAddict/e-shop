<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
$conn = new mysqli('localhost', 'root', '', 'e-shop');

function login_user($email, $password){

    global $conn;
    $sql = "SELECT * FROM users WHERE email = '{$email}'";
    $res = $conn->query($sql);

    if($res->num_rows<0){
        return FALSE;
    }

    $row = $res->fetch_assoc();

    if(! password_verify($password, $row['password'])) {
         return FALSE;   
    }

    $_SESSION['user'] = $row;

   return TRUE;
}