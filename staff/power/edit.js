function powerlist(parentid)
{
    var data=Object.Query(globaldata["power"],[1,parentid]);
    if(Object.Count(data))
    {
        var html="";
        $.each(data,function(k,v)
        {
            html+='<li class="line menulayer"><input type="radio" id=parentid'+k+' name="parentid" value="'+k+'"/><label for=parentid'+k+'>'+v[0]+'('+v[2]+')</label></li>';
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