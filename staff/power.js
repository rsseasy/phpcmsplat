function powerlist(parentid)
{
    var data=Object.Query(globaldata.power,[1,parentid]);
    if(Object.Count(data))
    {
        var html="";
        $.each(data,function(k,v)
        {
            html+='<li class="line menulayer"><input type="checkbox" id=offset'+k+' name="offset[]" value="'+v[2]+'"/><label for=offset'+k+'>'+v[0]+'(id:'+k+"-o:"+v[2]+')</label></li>';
            if(parseInt(k))
            {
                html+='<li class="menulayer"><ul>'+powerlist(k)+"</ul></li>";
            }
        });
        return html;
    }
    return "";
}

var datalist=$("#parentwrap");
datalist.html(powerlist(0));
var power=datalist.attr("powerlist");
var len=power.length;
for(var i=0;i<len;i++)
{
    if(power.substr(i,1)==1)
    {
        $("[value='"+(i+1)+"']").attr("checked",true);
    }
}
function checkcontext(id,checked)
{
    id=id.replace("offset","");
    var data=Object.Query(globaldata.power,[1,id]);
    $.each(data,function(k,v)
    {
        $("#offset"+k).prop("checked",checked);
        checkcontext(k,checked);
    });
}
function parentcontext(id,checked)
{
    id=id.replace("offset","");
    if(globaldata.power[id])
    {
        id=globaldata.power[id][1];
        if(id)
        {
            $("#offset"+id).prop("checked",checked);
            parentcontext(id,checked);
        }
    }
}
datalist.find("input").click(function()
{
    var id=this.id.replace("offset","");
    checkcontext(id,this.checked);

    var parentid=globaldata.power[id][1];
    var data=Object.Query(globaldata.power,[1,parentid]);
    for(var key in data)
    {
        if($("#offset"+key).prop("checked"))
        {
            parentcontext("offset"+key,true);
            return;
        }
    }
    parentcontext(this.id,false);
});