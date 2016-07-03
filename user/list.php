<?php
include_once '../library/config.php';
include_once '../model/stafflist.php';
include_once '../model/userlist.php';
StaffList::IsLogin();
$list = new UserList();
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
            <h2 class="pagetitle">手机号：<input type="number" name="account" value="<?php echo $list["account"]; ?>" class="w100" />
                <button type="submit">查询</button></h2>
            <div class="toolbar">
                <button type="button" transadapter="append" select="false">增加</button>
                <button type="button" transadapter="update">编辑</button>
                <button type="button" transadapter="delete">删除</button>
                <input type="hidden" id="transadapter" find="[name='myid']:checked" />
            </div>
            <div class="mainwrapassist">
                <table class="wp100 tc cellbor">
                    <thead float="float">
                        <tr>
                            <th class="w30">选择</th>
                            <th class="w120">登陆帐号</th>
                            <th>公众号</th>
                            <th class="w120">时间</th>
                            <th class="w120">登陆IP</th>
                            
                        </tr>
                    </thead>
                    <tbody id="datalist">
                        <?php
                        $list->pagesize = 15;
                        $list->select();
                        if($list['account'])
                        {
                            $list->where('account=?',array($list['account']));
                        }
                        $list->get_page_desc("myid");
                        while ($list->for_in_rows()) {
                            ?>
                            <tr>
                                <td>
                                <input type="radio" name="myid" value="<?php echo $list["myid"]; ?>" /></td>
                                <td><?php echo $list['account']; ?></td>
                                <td><?php echo $list['gongzhonghao']; ?></td>
                                <td riqidata="<?php echo $list['shijian']; ?>"></td>
                                <td ip="<?php echo $list['ip']; ?>"></td>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="statusbar">
                <?php
                $pag=new Pagination($list);
                $pag->pageinfo()->firstpage()->loop_page()->lastpage()->display();
                ?>
            </div>
        </form>
        <?php include_once '../inc/js.html'; ?>
        <script src="controller.js"></script>
    </body>
</html>

