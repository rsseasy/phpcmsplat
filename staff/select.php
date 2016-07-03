<%@ Page Language="C#" %>
<%@ Import Namespace="LocalDAL" %>
<%
    StaffList.IsLogin(); 
     %>
<!DOCTYPE html>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>选择人员</title>
    <style type="text/css">
        html, body { height: 100%; overflow: auto; }
    </style>
</head>
<body>
    <table class="wp100 tc" width="100%">
        <tbody id="datalist" datalist="1" mouseover="1">
            <%
                AdminList list = new AdminList();
                list.select().query();
                while (list.for_in_rows())
                { 
            %>
            <tr>
                <td>
                    <input type="checkbox" name="myid" value="<% Response.Write(list["myid"]); %>" />
                </td>
                <td>
                    <% Response.Write(list["realname"]); %>
                </td>
            </tr>
            <%
                }
            %>
        </tbody>
    </table>
    <button type="button">确定</button>
    <script src="../js/jquery.js"></script>
    <script src="../js/custom2.js"></script>
    <script>
        $("button").click(function()
        {
            var myids=$("[name=myid]:checked");
            var data={};
            myids.each(function()
            {
                var t=$(this);
                data[this.value]=t.parent().next().text().trim();
            });
            window.returnValue=data;
            window.close();
        });
    </script>
</body>
</html>
