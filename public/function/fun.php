<?php
function logout(){
    //session_unset();
    session_destroy();
    header('Location: ../login/login.php');
    exit();
}
function passwordhash($password){
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    return $password_hash;
}

function isAuthenticated() {
    return isset($_SESSION['user']);
    
}
?>