<?php
include_once '../library/config.php';
include_once '../library/popuphelper.php';
include_once '../library/powerhelper.php';
include_once '../model/stafflist.php';
include_once '../model/userlist.php';
StaffList::IsLogin();
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
        <form method="post" class="labelright nomargin">
            <?php
            $req=new HttpRequestHelper();
            $req->request();
            $entity=new StaffList();
            if (!empty($req["action"]))
            {
                PoPupHelper::iframereload();
                switch ($req["action"])
                {
                    case "update":
                        $powerlist=str_pad('0', 53, '0');
                        $power=$req["offset"];
                        $len=count($power);
                        $offset=0;
                        for ($i=0; $i<$len; $i++)
                        {
                            $offset=intval($power[$i]);
                            $powerlist=substr($powerlist, 0, $offset-1).'1'.substr($powerlist, $offset);
                        }
                        $powers=PowerHelper::GetIntPower($powerlist);
                        $entity->keyvalue("powerlist1", $powers[0]);
                        $entity->update()->where("myid=@myid", $req["id"])->submit();
                        PoPupHelper::showHtml("设置成功！");
                        break;
                }
                exit();
            }
            $entity->select()->where("myid=@id", $req["id"])->get_first_rows();
            ?>
            <div class="mainwrapassist notitletoolbar">
                <ul id="parentwrap" powerlist="<?php echo PowerHelper::GetPowerList($entity["powerlist1"]); ?>">
                </ul>
            </div>
            <div class="statusbar">
                <input type="hidden" name="action" value="update" />
                <button type="submit">设置</button>
            </div>
        </form>
        <script src="/data/power.js"></script>
        <?php include_once '../inc/js.html'; ?>
        <script src="power.js"></script>
    </body>
</html>
