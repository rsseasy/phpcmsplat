<?php
include_once 'library/config.php';
include_once 'model/userlist.php';
include_once 'model/stafflist.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>后台登录</title>
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            if (self != top)
            {
                top.location = self.location;
            }
        </script>
        <?php
        $req=new HttpRequestHelper();
        $req->request();
        try
        {
            if($req["action"]=="login")
            {
                if($_COOKIE["admincode"]!=$req["validatecode"])
                {
                    throw new Exception("验证码错误");
                }
                $entity=new UserList();
                if($entity->select()->where("account=?",array($req["account"]))->get_first_rows())
                {
                    if($entity["pwd"]!=md5($req["pwd"]))
                    {
                        throw new Exception("登录密码不正确！");
                    }
                    setcookie("myid",$entity["myid"]);
                    setcookie("realname",$entity["gongzhonghao"]);
                    setcookie("powerlist",$entity["powerlist"]);
                    header("location:index.php");
                }else
                {
                    throw new Exception("用户不存在！".$entity->sql);
                }
            }
        }catch(Exception $ex)
        {
            echo '<script type="text/javascript">alert("'.$ex->getMessage().'");</script>';
        }
        ?>
    </head>
    <body>
        <form method="post">
            <table id="login" class="wp100">
                <tbody>
                    <tr>
                        <td class="tr w250">用户名：
                        </td>
                        <td>
                            <input type="text" id="account" name="account" autofocus="true" value="<?php echo $req["account"]?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="tr">密码：
                        </td>
                        <td>
                            <input type="password" id="pwd" name="pwd" value="<?php echo $req["pwd"]?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="tr">验证码：
                        </td>
                        <td>
                            <input type="number" name="validatecode" class="w70" maxlength="5" /><img src="admincode.php" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <div>
                <input type="hidden" name="action" value="login" />
                <button type="submit">登录</button>
                <button type="reset">重置</button>
            </div>
        </form>
    </body>
</html>
