<?php
include_once '../library/config.php';
include_once '../library/popuphelper.php';
include_once '../library/fileextend.php';
include_once '../model/stafflist.php';
include_once '../model/articlelist.php';
include_once '../model/articleadvertlist.php';
include_once '../model/articleadvertlistview.php';
StaffList::IsLogin();
$entity=new ArticleAdvertList();
$entity->request();
if ($entity["action"]=="huandeng") {
    $entity->append()->submit();
    
    $entity=new ArticleAdvertListView();
    $entity->select('id,url,ico')->query();
    FileExtend::MakeFile(root.'/data/advert.json', $entity->toKeyValue());
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
                确认把此文章增加到幻灯吗？
            </div>
            <div id="statusbar">
                <input type="hidden" name="action" value="huandeng" />
                <button type="submit">确认</button>
            </div>
        </form>
        <?php include_once '../inc/js.html'; ?>
    </body>
</html>
