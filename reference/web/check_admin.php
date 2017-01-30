<?php
session_start();

function PA_CheckPageAccess(){  
if ($_SESSION['role']>=2){
return true;
}
else{
echo $_SESSION['username'];
return false; 
}
} 

function chechipaddress(){
if($_SERVER['HTTP_CLIENT_IP'])
{
        $onlineip = $_SERVER['HTTP_CLIENT_IP'];
	 
  }
        elseif ($_SERVER['HTTP_X_FORWARDED_FOR'])
  {
        $onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
        else{
        $onlineip = $_SERVER['REMOTE_ADDR'];
}

   return($onlineip);
}
$ip=chechipaddress();
$ip_a =  split("\.", $ip); 
  
if( !PA_CheckPageAccess()   ){ 
echo "  $ip you are not the administrator,or your ip address is not allowed!"; 
 

exit; 
} 
 




?> 