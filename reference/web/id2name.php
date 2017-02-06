<?php
//从登陆id到姓名的转化
$sql_id2name = "select *  from username";
$result = mysql_query($sql_id2name,$roche) or die(mysql_error()); 
$array_id2name=array();
while($row = mysql_fetch_array($result)){
	$array_id2name{$row[userid]}=$row[username];
}
?>