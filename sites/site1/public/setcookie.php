<?php
if(isset($_GET['username'])){
   setcookie("username", $_GET['username'], time()+3600);
   
}

if(isset($_GET['theme'])){
   setcookie("theme", $_GET['theme'], time()+3600);
}


setcookie('site_1', 'maivinhlam', time()+60*60*24*365, '/', '.site1.local', false);