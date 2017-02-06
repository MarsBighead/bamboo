<?php
date_default_timezone_set('Asia/Shanghai');

//---------------------------------------------------------------------------
// Filename   : wnl.php
// Author     : Bai Jianping<hakusan@sohu.com>
// Description : 万年历程序的主要逻辑功能实现部分
// Date       : 2005-03-18
// Version     : 1.0
// Copyright   : Chinux Team
//---------------------------------------------------------------------------
// History     :
//
// Date       Author         Modification
//---------------------------------------------------------------------------
// 2005-03-18   Bai Jianping   - create file
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------

$YYYY_MIN = 2008;     // 最小年份
$YYYY_MAX = 2020;     // 最大年份
$YYYYMM_MIN = 200801;     // 最小月份
$YYYYMM_MAX = 202012;     // 最大月份
if (isset($_POST['yyyymm']))
{
    // 由下拉选择框选择的年月
    if ($_POST['yyyymm'] == "SELECTFORMAT")
    {
        $yyyymm = $_POST['selectyyyy'] * 100 + $_POST['selectmm'];
    }
    // 由点击“本月”按钮选择的年月
    else if ($_POST['yyyymm'] == "THISMONTH")
    {
        $yyyymm = date("Ym");
    }
    else
    { 
        // 由点击“上一月”选择的年月
        if ($_POST['yyyymm'] == "LASTMM")
        {
              $_POST['yyyymm'] = $_POST['selectyyyy'] * 100 + $_POST['selectmm'] - 1;
        }
        // 由点击“下一月”选择的年月
        else if ($_POST['yyyymm'] == "NEXTMM")
        {
              $_POST['yyyymm'] = $_POST['selectyyyy'] * 100 + $_POST['selectmm'] + 1;
        }
        // 由点击“上一年”选择的年月
        else if ($_POST['yyyymm'] == "LASTYYYY")
        {
              $_POST['yyyymm'] = ($_POST['selectyyyy'] - 1) * 100 + $_POST['selectmm'];
        }
        // 由点击“下一年”选择的年月
        else if ($_POST['yyyymm'] == "NEXTYYYY")
        {
              $_POST['yyyymm'] = ($_POST['selectyyyy'] + 1) * 100 + $_POST['selectmm'];
        }
        
        // 限制最小与最大年月
        if ($_POST['yyyymm'] < $YYYYMM_MIN)
        {
              $yyyymm = $YYYYMM_MIN;
        }
        else if ($_POST['yyyymm'] > $YYYYMM_MAX)
        {
              $yyyymm = $YYYYMM_MAX;
        }
        else if ($_POST['yyyymm'] % 100 == 0)
        {
              $yyyymm = $_POST['yyyymm'] - 100 + 12;
        }
        else if ($_POST['yyyymm'] % 100 == 13)
        {
              $yyyymm = $_POST['yyyymm'] + 100 - 12;
        }
        else
        {
              $yyyymm = $_POST['yyyymm'];
        }
    }
}
// 如果是第一次访问则取当天的日期
else 
{
    $yyyymm = date("Ym");
}
$yyyy = floor($yyyymm/100);     // 要显示的年份
$mm = $yyyymm % 100;     //　要显示的月份
$dd = date("d");     // 当天日期

// 每月的天数
$days = array(1 => 31, 2 => 28, 3 => 31, 4 => 30, 5 => 31, 6 => 30,
              7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31);

// 判断是否是闰年
if ($yyyy % 400 == 0 || $yyyy % 4 == 0 && $yyyy % 100 != 0)
{
    $days[2] = 29;
}
// 判断所选年月的１号是本年第几天
for ($i = 1, $d = 1; $i < $mm; $i++)
{
    $d += $days[$i];
}
// 取得所选月１号是星期几
$week = (($yyyy - 1) + floor(($yyyy - 1)/4) - floor(($yyyy - 1)/100) + floor(($yyyy - 1)/400) + $d) % 7;
// 计算显示本月日历需要几行
$alldays = $week + $days[$mm];
if ($alldays % 7 == 0)
{
    $rows = floor($alldays/7);
}
else 
{
    $rows = floor($alldays/7) + 1;
}

// 构造显示月历数组
$dayarray = array();
for ($i = 0;$i < $week; $i++)
{
    $dayarray[] = "";
}
for ($i = 1; $i < $days[$mm] + 1; $i++)
{
    $dayarray[] = $i;
}
// 加入模板
require_once("wnl2.html")
?>
