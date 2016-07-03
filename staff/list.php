<?php
include_once '../library/config.php';
include_once '../model/stafflist.php';
include_once '../model/userlist.php';
include_once '../model/stafflistview.php';
StaffList::IsLogin();
$list=new StaffListView();
$list->request();
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
            <h2 class="pagetitle">手机号：<input type="number" name="account" value="<?php echo $list["action"]; ?>" class="w100" />
                <input type="hidden" name="action" value="search" />
                <button type="submit">查询</button></h2>
            <div class="toolbar">

                <button type="button" transadapter="deletexinxi">删除</button>
                <button type="button" transadapter="editxinxi">修改</button>
                
                
                <input type="hidden" id="transadapter" find="[name='myid']:checked" />
            </div>
            <div class="mainwrapassist nostatusbar">
                <table class="tc cellbor">
                    <thead float="float">
                        <tr>
                            <th class="w30">选择</th>
                            <th class="w60">MyID</th>
                            <th class="w150">手机号</th>
                            <th class="w100">姓名</th>
                            <th class="w150">注册时间</th>
                        </tr>
                    </thead>
                    <tbody id="datalist">
                        <?php
                        $list->select()->query();
                        while ($list->for_in_rows())
                        {
                            ?>
                            <tr>
                                <td>
                                    <input type="radio" name="myid" value="<?php echo $list["myid"]; ?>" /></td>
                                <td><?php echo $list["nicheng"]; ?></td>
                                <td><?php echo $list["account"]; ?></td>
                                <td><?php echo $list["powerlist1"]; ?></td>
                                <td riqidata="<?php echo $list["shijian"]; ?>"></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
        <?php include_once '../inc/js.html'; ?>
        <script src="controller.js"></script>
    </body>
</html>
