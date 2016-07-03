<?php
include_once '../../library/config.php';
include_once '../../model/stafflist.php';
include_once '../../model/userlist.php';
include_once '../../model/powerlist.php';
StaffList::IsLogin();
$entity=new PowerList();
$entity->select("max(offset) as offset")->get_first_cell();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link href="/css/reset.css" rel="stylesheet" type="text/css" />
        <link href="/css/layout.css" rel="stylesheet" type="text/css" />
        <title>后台管理系统</title>
    </head>
    <body>
        <form method="post" id="mainwrap">
            <div class="toolbar">
                <button type="button" appendxinxi="#transadapter">增加</button>
                <button type="button" editxinxi="#transadapter">编辑</button>
                最大权限位：<?php echo $entity["offset"]; ?>
                <input type="hidden" id="transadapter" find="[name='parentid']:checked" />
            </div>
            <div class="mainwrapassist nopagetitle nostatusbar">
                <ul id="parentwrap" class="lanmubankuai"></ul>
            </div>
        </form>
        <script src="/data/power.js"></script>
        <?php include_once '../../inc/js.html'; ?>
        <script src="edit.js"></script>
        <script src="controller.js"></script>
        <script src="/js/menuhelper.min.js"></script>
    </body>
</html>
