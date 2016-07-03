<?php
include_once '../../library/config.php';
include_once '../../library/fileextend.php';
include_once '../../model/powerlist.php';

$json="if(!window.globaldata)\n";
$entity=new PowerList();
$entity->toJson();

echo '已生成完毕';
include_once '../../inc/js.html';
