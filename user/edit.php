<?php
include_once '../library/config.php';
include_once '../library/popuphelper.php';
include_once '../model/stafflist.php';
include_once '../model/userlist.php';
StaffList::IsLogin();
$entity = new UserList();
$entity->request()->remove(array('id'));
if ($entity['action']) {
    PoPupHelper::iframereload();
    $entity->keyvalue('pwd', md5($entity['pwd']));
    switch ($entity['action']) {
        case 'append':
            $entity->timestamp();
            $entity->append()->submit();
            
            $staff=new StaffList();
            $staff->keyvalue('myid', $entity->autoid);
            $staff->append()->submit();
            break;
        case 'update':
            $entity->update()->where('myid=?',array($entity['id']))->submit();
            break;
    }
    PoPupHelper::showSucceed();
}
$entity->select()->where('myid=?',array($entity['id']))->get_first_rows();
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
                        <td class="tr w80">登陆帐号：</td>
                        <td><input type="text" name="account" class="w150" value="<?php echo $entity['account']; ?>"/>
                        请使用手机号
                        </td>
                    </tr>
                    <tr>
                        <td class="tr">登陆密码：</td>
                        <td><input type="text" name="pwd" class="w150" value="<?php echo $entity['pwd']; ?>"/></td>
                    </tr>
                     <tr>
                        <td class="tr">公众号：</td>
                        <td><input type="text" name="gongzhonghao" class="w150" value="<?php echo $entity['gongzhonghao']; ?>"/></td>
                    </tr>
                     <tr>
                        <td class="tr">公众帐号：</td>
                        <td><input type="text" name="gongzhongzhanghao" class="w150" value="<?php echo $entity['gongzhongzhanghao']; ?>"/></td>
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

