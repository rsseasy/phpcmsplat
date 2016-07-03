<?php
include_once '../library/config.php';
include_once '../library/mysqlhelper.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>表结构</title>
        <style type="text/css">
            body{display:block; width: 1000px; margin:0 auto;}
            table{ width: 100%;}
            td{ border: solid 1px gray;}
            .tablename td{font-weight: bold; font-size: 14px; border: none; padding-top: 10px; text-align: center;}
            .header td{ text-align: center; }
        </style>
    </head>
    <body>
        <table>
            <thead><tr class="header"><td>字段名称</td><td>数据类型</td><td>是否为空</td><td>扩展属性</td><td>注释</td></td></tr></thead>
            <tbody>
                <?php
                $tables = new MySqlHelper();
                $tables->getTables();

                $entity = new MySqlHelper();
                while ($tables->for_in_rows()) {
                    echo '<tr class="tablename"><td colspan="5">表名：' . $tables['Name'] . '(' . $tables['Comment'] . ')</td></tr>';
                    $entity->tablename = $tables['Name'];
                    $entity->getSchema();
                    while ($entity->for_in_rows()) {
                        ?>
                        <tr>
                            <td><?php echo $entity['Field']; ?></td><td><?php echo $entity['Type']; ?></td><td><?php echo $entity['Null']; ?></td><td><?php echo $entity['Extra']; ?></td><td><?php echo $entity['Comment']; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </body>
</html>
