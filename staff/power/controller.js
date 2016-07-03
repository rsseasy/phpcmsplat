//权限
transadapter["appendxinxi"]=function(t)
{
    popuplayer.display("/staff/power/edit.php&TB_iframe=true",'增加权限',{ width: 550,height: 350 });
}
transadapter["editxinxi"]=function(t)
{
    popuplayer.display("/staff/power/edit.php?id="+transadapter.id+"&TB_iframe=true",'编辑权限',{ width: 550,height: 350 });
}