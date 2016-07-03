<?php
include_once(root . '/library/mysqlhelper.php');
class StaffListView extends MySqlHelper {
    public function __construct() {
        parent::__construct("staff_list_view");
    }
}
?>