<?php
$hostname_con = "bd_kaizens.mysql.dbaas.com.br";
$username_con = "bd_kaizens";
$password_con = "Kaizens#x0";
$con_kaizens_prd = mysqli_connect($hostname_con, $username_con, $password_con); 
mysqli_set_charset($con_kaizens_prd,"utf8");
mysqli_select_db($con_kaizens_prd, "bd_kaizens");
?>
