<?php

session_start();
session_unset();
session_destroy();

setcookie("user_id",'',time()-3600,'/');
setcookie("admin_id",'',time()-3600,'/');

header("Location:index.php");
?>