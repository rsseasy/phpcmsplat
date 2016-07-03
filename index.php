<?php
include_once 'library/config.php';
include_once 'model/stafflist.php';
StaffList::IsLogin();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width,user-scalable=no" />
        <meta charset="utf-8" />
        <title>管理系统</title>
        <link href="/css/reset.css" rel="stylesheet" type="text/css" />
        <link href="/css/index.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            if (self !== top)
            {
                top.location = self.location;
            }
        </script>
    </head>
    <body>
        <div id="header">
            <ul id="nav">
            </ul>
        </div>
        <div id="content">
            <div id="leftscroll">
                <div id="left">
                    <ul id="leftMenus">
                    </ul>
                </div>
            </div>
            <div id="right">
                <iframe style="border: none;" width="100%" height="100%" id="workspace" name="workspace" src="about:blank"></iframe>
            </div>
        </div>
        <div id="footer" backbtn="no">
            <div id="login">
                <a href="loginout.php">
                    <img src="css/img/out.png" />退出</a><span id="controlbtn">菜单开关</span>
            </div>
        </div>
        <script src="js/iscroll.min.js"></script>
        <?php include_once '/inc/js.html';?>
        <script src="js/menudata.js"></script>
        <script src="js/index.min.js?v=2"></script>
    </body>
</html>
