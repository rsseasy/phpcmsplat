<?php
include_once '../library/config.php';
include_once '../library/popuphelper.php';
include_once '../model/stafflist.php';
include_once '../model/stafflistview.php';
include_once '../model/userlist.php';
$req=new HttpRequestHelper();
$req->request();
$entity=new StaffListView();
$admin=new StaffList();
if (!string.IsNullOrEmpty(req["action"]))
{
    admin.keyvalue(req).remove("action", "account", "staffmyid");
    PoPupHelper.iframereload();
    switch (req["action"])
    {
        case "update":
            admin.update().where("staffmyid=@staffmyid", req["staffmyid"]).submit();
            PoPupHelper.showHtml("修改成功！");
            break;
    }
    Response.End();
}
entity.select().where("staffmyid=@staffmyid", req["staffmyid"]).get_first_rows();
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
        <form method="post" class="labelright nomargin">
            <div class="mainwrapassist notitletoolbar">
                <table class="wp100 cellbor">
                    <tr>
                        <td class="tr w100">帐号：</td>
                        <td><% Response.Write(entity["account"]); %></td>
                    </tr>
                    <tr>
                        <td class="tr">座机号：</td>
                        <td>
                            <input type="text" name="zuoji" maxlength="25" value="<% Response.Write(entity["zuoji"]); %>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="tr">企业邮箱：</td>
                        <td>
                            <input type="text" name="email" maxlength="25" value="<% Response.Write(entity["email"]); %>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="tr">部门：</td>
                        <td>
                            <select bumen="<% Response.Write(entity["bumenid"]); %>" name="bumenid" datadict="staff" datakey="bumen"></select></td>
                    </tr>
                    <tr>
                        <td class="tr">职务：</td>
                        <td>
                            <select gangwei="<% Response.Write(entity["gangweiid"]); %>" datadict="staff" datakey="gangwei" name="gangweiid">
                        </select></td>
                </tr>
                <tr>
                    <td class="tr">上级：</td>
                    <td>
                        <select name="shangjimyid" def="<% Response.Write(entity["shangjimyid"]); %>">
                                <option value="0">无</option>
                                    <?PHP
                                    $list=new StaffListView();
                                    $list->select("staffmyid,realname")->orderby("staffmyid")->query();
                                    while ($list->for_in_rows())
                                    {
                                        ?>
                                <option value="<?PHP echo $list["staffmyid"]; ?>"><?PHP echo $list["realname"]; ?></option>
    <?PHP
}
?>
                        </select></td>
                </tr>
            </table>
        </div>
        <div id="statusbar">
            <input type="hidden" name="action" value="<?PHP echo $list["id"]?"append":"update"; ?>" />
            <button type="submit" submitvalidate="#thisform"><?PHP echo $list["id"]?"增加":"修改"; ?></button>
        </div>
    </form>
    <script src="/data/staff.js"></script>
<?php include_once '../inc/js.html'; ?>
</body>
</html>
