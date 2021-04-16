<?php
if(isset($_GET['username'])){
   setcookie("username", $_GET['username'], time()+3600);
}
?>