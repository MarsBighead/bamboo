<?php
Header("Content-type: image/gif");
/*
* ��ʼ��
*/
$border = 0; //�Ƿ�Ҫ�߿� 1Ҫ:0��Ҫ
$how = 4; //��֤��λ��
$w = $how*15; //ͼƬ���
$h = 20; //ͼƬ�߶�
$fontsize = 5; //�����С
$alpha = "abcdefghijkmnopqrstuvwxyz"; //��֤������1:��ĸ
$number = "023456789"; //��֤������2:����
$randcode = ""; //��֤���ַ�����ʼ��
srand((double)microtime()*1000000); //��ʼ�����������

$im = ImageCreate($w, $h); //������֤ͼƬ

/*
* ���ƻ������
*/
$bgcolor = ImageColorAllocate($im, 255, 255, 255); //���ñ�����ɫ
ImageFill($im, 0, 0, $bgcolor); //��䱳��ɫ
if($border)
{
    $black = ImageColorAllocate($im, 0, 0, 0); //���ñ߿���ɫ
    ImageRectangle($im, 0, 0, $w-1, $h-1, $black);//���Ʊ߿�
}

/*
* ��λ��������ַ�
*/
for($i=0; $i<$how; $i++)
{   
    $alpha_or_number = mt_rand(0, 1); //��ĸ��������
    $str = $alpha_or_number ? $alpha : $number;
    $which = mt_rand(0, strlen($str)-1); //ȡ�ĸ��ַ�
    $code = substr($str, $which, 1); //ȡ�ַ�
    $j = !$i ? 4 : $j+15; //���ַ�λ��
    $color3 = ImageColorAllocate($im, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100)); //�ַ��漴��ɫ
    ImageChar($im, $fontsize, $j, 3, $code, $color3); //���ַ�
    $randcode .= $code; //��λ������֤���ַ���
}


/*
* ��Ӹ���
*/

/*for($i=0; $i<5; $i++)//�汳��������
{   
    $color1 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //��������ɫ
    ImageArc($im, mt_rand(-5,$w), mt_rand(-5,$h), mt_rand(20,300), mt_rand(20,200), 55, 44, $color1); //������
}*/   
for($i=0; $i<$how*40; $i++)//�汳�����ŵ�
{   
    $color2 = ImageColorAllocate($im, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255)); //���ŵ���ɫ 
    ImageSetPixel($im, mt_rand(0,$w), mt_rand(0,$h), $color2); //���ŵ�
}

//����֤���ַ���д��session
session_start();
$_SESSION['randcode'] = $randcode;

/*��ͼ����*/
Imagegif($im);
ImageDestroy($im);
/*��ͼ����*/
?> 