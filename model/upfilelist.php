<?php
include_once(root.'/library/mysqlhelper.php');
class UpfileList extends MySqlHelper {
    public function __construct() {
        parent::__construct("upfile_list");
    }
}
?>