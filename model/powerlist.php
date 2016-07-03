<?php
include_once(root.'/library/mysqlhelper.php');
class PowerList extends MySqlHelper {
    public function __construct() {
        parent::__construct("power_list");
    }
}
?>