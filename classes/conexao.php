<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

//$hostname_con = "10.199.102.200";
$username_con = "automacao";
$password_con = "@utomaca0";
$hostname_con = "localhost";
//$username_con = "root";
//$password_con = "usbw";

$con = mysqli_connect($hostname_con, $username_con, $password_con) or trigger_error(mysqli_error(),E_USER_ERROR); 
mysqli_set_charset($con,"utf8");

?>