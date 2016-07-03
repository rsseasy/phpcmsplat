<?php
//全局配置文件 
    header("Content-type: text/html; charset=utf-8"); //页面编码设置
    date_default_timezone_set("PRC");  //时区设置
    define('webname','中企聚易管理系统');  //网站名称
    define('root',$_SERVER['DOCUMENT_ROOT']);  //主目錄
    define('db_host','localhost');  //定义数据库主机地址
    define('db_username','root');  //登陆数据库的用户名
    define('db_password','www.rsseasy.com');  //登陆数据库的密码
    define('db_database','rsseasy');   //数据库的名称
    define('db_charset','utf8');   //数据库的编码
    define('db_prefix','');   //数据表名前缀
    define('upfile',root.'/upfile/');  //上传文件存储物理位置
    define('icp', '京ICP备12035142号');   //ICP备案号    
    
    define('weixinappid','wx49e3140fb6da89fd');
    define('weixinmchid','1349334101');
?>
