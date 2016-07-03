<?php
include_once '../library/config.php';
include_once '../model/stafflist.php';
include_once '../model/articleadvertlistview.php';
StaffList::IsLogin();
$list = new ArticleAdvertListView();
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
            <h2 class="pagetitle">文章列表</h2>
            <div class="toolbar">       
                <button type="button" transadapter="delete">删除</button> 
                <input type="hidden" id="transadapter" find="[name='id']:checked" />
            </div>
            <div class="mainwrapassist">
                <table class="wp100 tc cellbor">
                    <thead>
                        <tr>
                            <th class="w30">选择</th>
                            <th class="w50">ID</th>
                            <th>标题</th>
                            <th class="w120">时间</th>
                        </tr>
                    </thead>
                    <tbody id="datalist">
                        <?php
                        $list->pagesize = 13;
                        $list->select('id,title,shijian')->orderby('id desc')->query();
                        while ($list->for_in_rows()) {
                            ?>
                            <tr>
                                <td><input type="radio" name="id" value="<?php echo $list["id"]; ?>" /></td>
                                <td><?php echo $list['id']; ?></td>
                                <td class="tl"><?php echo $list['title']; ?></td>
                                <td riqidata="<?php echo $list['shijian']; ?>"></td>
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

