<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_roche = "localhost";
$database_roche = "genesky";
$username_roche = "lch";
$password_roche = "licaihua";
$roche = mysql_pconnect($hostname_roche, $username_roche, $password_roche) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES UTF8");
session_start();
date_default_timezone_set('Asia/Shanghai');
?>
