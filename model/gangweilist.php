<?php
include_once(root . '/library/mysqlhelper.php');
class GangWeiList extends MySqlHelper {
    public function __construct() {
        parent::__construct("gangwei_list");
    }
}
?>