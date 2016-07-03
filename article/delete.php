<?php
include_once '../library/config.php';
include_once '../library/popuphelper.php';
include_once '../model/stafflist.php';
include_once '../model/articlelist.php';
StaffList::IsLogin();
$entity=new ArticleList();
$entity->request();
if ($entity["action"]=="delete") {
    PoPupHelper::iframereload();
    $entity->delete()->where("id=?", array($entity["id"]))->submit();
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
                删除后不可恢复，请谨慎操作？
            </div>
            <div id="statusbar">
                <input type="hidden" name="action" value="delete" />
                <button type="submit">确认</button>
            </div>
        </form>
        <?php include_once '../inc/js.html'; ?>
    </body>
</html>
