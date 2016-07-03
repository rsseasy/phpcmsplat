<?php
include_once '../library/config.php';
include_once '../library/popuphelper.php';
include_once '../library/fileuploadthumb.php';
include_once '../model/stafflist.php';
include_once '../model/articlelist.php';
StaffList::IsLogin();
$entity = new ArticleList();
$entity->request();
if ($entity['action']) {
    $upfile = new FileUploadThumb();
    if ($upfile->upload('upfile', array('value' => 150))) {
        $entity->keyvalue('ico', str_replace('/upfile/', '', $upfile->fileinfo->url));
    }
    $entity->remove(array('upfile','id'));
    if($entity['kaishiriqi'])
    {
        $entity->keyvalue('kaishiriqi', strtotime($entity['kaishiriqi']));
    }
    
    if($entity['jieshuriqi'])
    {
        $entity->keyvalue('jieshuriqi', strtotime($entity['jieshuriqi']));
    }
    PoPupHelper::iframereload();
    switch ($entity['action']) {
        case 'append':
            $entity->timestamp()->keyvalue('myid', $_COOKIE['myid']);
            $entity->append()->submit();
            break;
        case 'update':
            $entity->update()->where('id=?',array($entity['id']))->submit();
            break;
    }
    PoPupHelper::showSucceed();
}
$entity->select()->where('id=?',array($entity['id']))->get_first_rows();
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
        <form method="post" enctype="multipart/form-data" class="labelright nomargin">
            <div class="mainwrapassist notitletoolbar">
                <table class="wp100 cellbor">
                    <tr>
                        <td class="tr w80">标题：</td>
                        <td><input type="text" name="title" class="w500" value="<?php echo $entity['title']; ?>"/></td>
                    </tr>
                    <tr>
                        <td class="tr">ICO：</td>
                        <td>
                            <input type="file" name="upfile"/>
                            <img src="/upfile/<?php echo str_replace('.', 'l.', $entity['ico']); ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="tr">Url：</td>
                        <td>
                            <input type="text" name="url" class="w500" value="<?php echo $entity['url']; ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="tr">开始时间：</td>
                        <td>
                            <input type="text" name="kaishiriqi" class="w100" calendar="" riqidata="<?php echo $entity['kaishiriqi']; ?>,yyyy-MM-dd"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="tr">结束时间：</td>
                        <td>
                            <input type="text" name="jieshuriqi" class="w100" calendar="" riqidata="<?php echo $entity['jieshuriqi']; ?>,yyyy-MM-dd"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="statusbar">
                <input type="hidden" name="action" value="<?PHP echo $entity["id"] ? "update" : "append"; ?>" />
                <button type="submit"><?PHP echo $entity["id"] ? "修改" : "增加"; ?></button>
            </div>
        </form>
        <?php include_once '../inc/js.html'; ?>
    </body>
</html>

