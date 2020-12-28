<?php
session_start();
session_destroy();
setcookie('clientcookie','',time()-1);
echo ("<script>window.open('adminLogin.php','_self')</script>");
?>