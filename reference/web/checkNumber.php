<?php
session_start();

if($_GET['act'] == "init")
{
    Header("Content-type: image/png");
    srand(microtime() * 100000);
    $login_check_number = strval(rand("1111","9999"));
    session_unregister("login_check_number");
    session_register("login_check_number");
    //这里是使用了SESSION来保存校验码.
    //当然也可以用COOKIE
    //setcookie("login_check_number",$login_check_number);
    //然后将第一行的session_start()删除;
    //不推荐使用COOKIE,因为使用COOKIE并不能进行安全的验证.

    $h_img = imagecreate(40,17);
    $c_black = ImageColorAllocate($h_img, 0,0,0);
    $c_white = ImageColorAllocate($h_img, 255,255,255);
    imageline($h_img, 1, 1, 350, 25, $c_black);
    imagearc($h_img, 200, 15, 20, 20, 35, 190, $c_white);
    imagestring($h_img, 5, 2, 1, $login_check_number, $c_white);
    ImagePng($h_img);
    ImageDestroy($h_img);

    die();
}