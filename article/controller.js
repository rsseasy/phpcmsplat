transadapter["append"]=function(t)
{
    popuplayer.display("/article/edit.php?TB_iframe=true",'增加文章',{ width: 600,height: 350 });
}
transadapter["update"]=function(t)
{
    popuplayer.display("/article/edit.php?id="+transadapter.id+"TB_iframe=true",'编辑文章',{ width: 600,height: 350 });
}
transadapter["delete"]=function(t)
{
    popuplayer.display("/article/delete.php?id="+transadapter.id+"TB_iframe=true",'删除文章',{ width: 300,height: 80 });
}
transadapter["view"]=function(t)
{
    popuplayer.display("/article/view.php?id="+transadapter.id+"TB_iframe=true",'查看文章',{ width: 300,height: 80 });
}
transadapter["huandeng"]=function(t)
{
    popuplayer.display("/article/huandeng.php?id="+transadapter.id+"TB_iframe=true",'增加到幻灯',{ width: 300,height: 80 });
}