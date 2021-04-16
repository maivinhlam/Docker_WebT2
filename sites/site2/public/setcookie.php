<?php

// header("Access-Control-Allow-Credentials: true");
// header("Access-Control-Allow-Origin: http://site1.local:9090");

if(isset($_GET['theme'])){
   setcookie("theme", $_GET['theme'], time()+3600);
}

// $arr_cookie_options = array (
//    'expires' => time() + 60*60*24*30,
//    'path' => '/',
//    'domain' => '.site2.local', // leading dot for compatibility or use subdomain
//    'secure' => false,     // or false
//    'httponly' => false,    // or false
//    'samesite' => 'None' // None || Lax  || Strict
//    );
// setcookie('site_2_1', 'The Cookie Value', $arr_cookie_options); 
setcookie("site_2", "subinsb.com", time()+3600);


?>