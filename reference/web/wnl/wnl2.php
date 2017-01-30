<?php
date_default_timezone_set('Asia/Shanghai');

//---------------------------------------------------------------------------
// Filename   : wnl.php
// Author     : Bai Jianping<hakusan@sohu.com>
// Description : �������������Ҫ�߼�����ʵ�ֲ���
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

$YYYY_MIN = 2008;     // ��С���
$YYYY_MAX = 2020;     // ������
$YYYYMM_MIN = 200801;     // ��С�·�
$YYYYMM_MAX = 202012;     // ����·�
if (isset($_POST['yyyymm']))
{
    // ������ѡ���ѡ�������
    if ($_POST['yyyymm'] == "SELECTFORMAT")
    {
        $yyyymm = $_POST['selectyyyy'] * 100 + $_POST['selectmm'];
    }
    // �ɵ�������¡���ťѡ�������
    else if ($_POST['yyyymm'] == "THISMONTH")
    {
        $yyyymm = date("Ym");
    }
    else
    { 
        // �ɵ������һ�¡�ѡ�������
        if ($_POST['yyyymm'] == "LASTMM")
        {
              $_POST['yyyymm'] = $_POST['selectyyyy'] * 100 + $_POST['selectmm'] - 1;
        }
        // �ɵ������һ�¡�ѡ�������
        else if ($_POST['yyyymm'] == "NEXTMM")
        {
              $_POST['yyyymm'] = $_POST['selectyyyy'] * 100 + $_POST['selectmm'] + 1;
        }
        // �ɵ������һ�ꡱѡ�������
        else if ($_POST['yyyymm'] == "LASTYYYY")
        {
              $_POST['yyyymm'] = ($_POST['selectyyyy'] - 1) * 100 + $_POST['selectmm'];
        }
        // �ɵ������һ�ꡱѡ�������
        else if ($_POST['yyyymm'] == "NEXTYYYY")
        {
              $_POST['yyyymm'] = ($_POST['selectyyyy'] + 1) * 100 + $_POST['selectmm'];
        }
        
        // ������С���������
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
// ����ǵ�һ�η�����ȡ���������
else 
{
    $yyyymm = date("Ym");
}
$yyyy = floor($yyyymm/100);     // Ҫ��ʾ�����
$mm = $yyyymm % 100;     //��Ҫ��ʾ���·�
$dd = date("d");     // ��������

// ÿ�µ�����
$days = array(1 => 31, 2 => 28, 3 => 31, 4 => 30, 5 => 31, 6 => 30,
              7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31);

// �ж��Ƿ�������
if ($yyyy % 400 == 0 || $yyyy % 4 == 0 && $yyyy % 100 != 0)
{
    $days[2] = 29;
}
// �ж���ѡ���µģ����Ǳ���ڼ���
for ($i = 1, $d = 1; $i < $mm; $i++)
{
    $d += $days[$i];
}
// ȡ����ѡ�£��������ڼ�
$week = (($yyyy - 1) + floor(($yyyy - 1)/4) - floor(($yyyy - 1)/100) + floor(($yyyy - 1)/400) + $d) % 7;
// ������ʾ����������Ҫ����
$alldays = $week + $days[$mm];
if ($alldays % 7 == 0)
{
    $rows = floor($alldays/7);
}
else 
{
    $rows = floor($alldays/7) + 1;
}

// ������ʾ��������
$dayarray = array();
for ($i = 0;$i < $week; $i++)
{
    $dayarray[] = "";
}
for ($i = 1; $i < $days[$mm] + 1; $i++)
{
    $dayarray[] = $i;
}
// ����ģ��
require_once("wnl2.html")
?>
