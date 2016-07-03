
transadapter["delete"]=function(t)
{
    popuplayer.display("/user/delete.php?id="+transadapter.id+"&TB_iframe=true",'删除联盟帐号',{ width: 300,height: 100 });
}
transadapter["append"]=function(t)
{
    popuplayer.display("/user/edit.php?id="+transadapter.id+"&TB_iframe=true",'增加联盟帐号',{ width: 400,height: 200 });
}
transadapter["update"]=function(t)
{
    popuplayer.display("/user/edit.php?id="+transadapter.id+"&TB_iframe=true",'编辑联盟帐号',{ width: 400,height: 200 });
}
