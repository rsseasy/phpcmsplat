<?php
include_once(root . '/library/mysqlhelper.php');
class BuMenList extends MySqlHelper {
    public function __construct() {
        parent::__construct("bumen_list");
    }
}
?>