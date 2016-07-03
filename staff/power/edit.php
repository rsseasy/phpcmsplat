<?php
include_once '../../library/config.php';
include_once '../../library/popuphelper.php';
include_once '../../library/fileextend.php';
include_once '../../model/stafflist.php';
include_once '../../model/powerlist.php';
StaffList::IsLogin();
$entity=new PowerList();
$entity->request();
if ($entity["action"])
{
    PoPupHelper::iframereload();
    switch ($entity["action"])
    {
        case "append":;
            $entity->append()->submit();
            PoPupHelper::showHtml("增加成功！");
            break;
        case "update":
            $entity->update()->where("id=@id", array($entity["id"]))->submit();
            PoPupHelper::showHtml("修改成功！");
            break;
    }
    $entity->toJson();
    exit();
}
$entity->select()->where("id=@id", array($entity["id"]))->get_first_rows();
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
        <form method="post" class="lightbox nomargin">
            <div class="mainwrapassist notitletoolbar nostatusbar">
                <table class="wp100 top">
                    <tbody>
                        <tr>
                            <td class="w200">
                                <ul id="parentwrap" class="h330 scrollauto lanmubankuai marleft2m pad0"></ul>
                            </td>
                            <td>
                                <table class="wp100 cellbor">
                                    <tr>
                                        <td class="tr w80">名称：
                                        </td>
                                        <td>
                                            <input type="text" id="mingcheng" name="mingcheng" class="w100" value="<?php echo $entity['mingcheng']; ?>" maxlength="50" /><label for="mingcheng"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tr">权限位：
                                        </td>
                                        <td>
                                            <input type="text" id="power" allowinput="number" name="power" class="w60" value="<?php echo $entity['power']; ?>" maxlength="50" /><label for="power"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="hidden" name="action" value="<?PHP echo empty($entity["id"])?"append":"update"; ?>" />
                                            <button type="submit" submitvalidate="#thisform"><?PHP echo empty($entity["id"])?"增加":"修改"; ?></button>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
        <script src="/data/power.js"></script>
        <?php include_once '../../inc/js.html'; ?>
        <script src="/js/menuhelper.min.js"></script>
        <script src="edit.js"></script>
        <script type="text/javascript">
            $(window).ready(function ()
            {
                $("[name=parentid]").val([<?php echo $entity['parentid']; ?>]);
            });
        </script>
    </body>
</html>
