<?php
include_once '../library/config.php';
include_once '../library/popuphelper.php';
include_once '../model/stafflist.php';
include_once '../model/userlist.php';
StaffList::IsLogin();
$entity=new UserList();
$entity->request()->remove('id','neirong');
if ($entity["action"]=="delete") {
    PoPupHelper::iframereload();
    $entity->update()->where("myid=?", array($entity["id"]))->submit();
    PoPupHelper::showSucceed();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>提交信息</title>
        <link href="/css/reset.css" rel="stylesheet" type="text/css" />
        <link href="/css/layout.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <form method="post" class="lightbox nomargin">
            <div class="mainwrapassist notitletoolbar tishixinxiwrap">
                <input type="radio" name="fenghao" value="1" /><label>解封</label>
                <input type="radio" name="fenghao" value="2"/><label>封号</label><br/><br/>
                <textarea rows="20" cols="40" name="neirong"></textarea>
            </div>
            <div id="statusbar">
                <input type="hidden" name="action" value="delete" />
                <button type="submit">确认</button>
            </div>
        </form>
        <?php include_once '../inc/js.html'; ?>
    </body>
</html>
