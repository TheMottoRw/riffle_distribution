<?php
include "phpqrcode/qrlib.php";
$PNG_WEB_DIR = 'qrcodes/';

//ofcourse we need rights to create temp dir
if (!file_exists($PNG_WEB_DIR))
    mkdir($PNG_WEB_DIR);


if(isset($_REQUEST['data'])){
    $filename = $PNG_WEB_DIR.base64_encode($_REQUEST['data']).'.png';
    QRcode::png($_REQUEST['data'], $filename, "L", 4, 2);
    echo '<img src="'.$filename.'" /><hr/>';
    echo "<script>window.print()</script>";
}
?>

