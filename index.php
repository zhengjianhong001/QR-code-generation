<?php
/**
 * php7下生成二维码
 * `利用composer管理类`
 * @authors Ryan Zheng 
 * @date    2018-11-25 23:54:05
 * @version 1.1
 */
error_reporting(0);
//引入composer自动生成的类加载器
require_once 'vendor/autoload.php';
//命名空间方式调用QrCode类
use Endroid\QrCode\QrCode as EndroidQrCode;//将QrCode命名空间腾出来
 
//处理需生成二维码的内容、参数和文字
$data  = trim($_GET['data']) ? trim($_GET['data']) : 'http://www.cnblogs.com/ryanzheng';
$size  = intval($_GET['size']) > 1000 ? 1000 : intval($_GET['size']);
$label = trim($_GET['label']) ? trim($_GET['label']) : null;
$label = "cnblog ryan.zheng";
$QrModel = new EndroidQrCode();
##默认参数
$QrModel->setText($data) //设置二维码上的内容
        ->setPadding(5) //设置二维码内容距离图片边缘的便宜量，单位：像素px
        ->setErrorCorrection('high') //设置二维码的纠错率，可以有low、medium、quartile、hign多个纠错率
        ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0)) //设置二维码的rgb颜色和透明度a，这里是黑色
        ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0)) //设置二维码图片的背景底色，这里是白色
        ->setImageType(EndroidQrCode::IMAGE_TYPE_PNG);//设置输出的二维码图片格式，这里设置成png格式，还可以有gif、jpeg、wbmp
###可能的指定生成的二维码尺寸，由get变量获取
$size ? $QrModel->setSize(intval($size)) : $QrModel->setSize(190);
###可能的指定二维码下方的文字，由get变量获取；写死15px的字体大小，方正静蕾简体手写体的字体
$label && $QrModel->setLabelFontPath('./Justus-ItalicOldstyle.woff.ttf')->setLabel($label)->setLabelFontSize(15);
###设置输出的header头：输出的内容是一张图片
// header('Content-Type: '.$QrModel->getContentType());
##QrCode类的输出png图片数据的方法输出图片，这个时候使用浏览器访问这个Url将显示一张二维码图片
// $QrModel->render();
 
###如果要加上logo水印，则在调用render方法之前调用setLogo和setLogoSize方法
$QrModel->setLogo('./ryan.jpg');//设置logo水印图片的路径，相对路径和绝对路径均可，这里`./logo.png`表示使用与本文件平级的logo.png
$QrModel->setLogoSize(48);//设置logo水印的大小，参数是一个int数字，单位px (注意：这里假设你的logo是一个正方形)

header('Content-Type: '.$QrModel->getContentType());
$QrModel->render();
