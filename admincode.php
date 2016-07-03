<?php
include_once 'library/graphicsextend.php';
$validate=new GraphicsExtend();
$validate->ValidateCodeForCookie("admincode", 75, 26, 16);
?>
