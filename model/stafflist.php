<?php
include_once(root . '/library/mysqlhelper.php');
class StaffList extends MySqlHelper {
    public function __construct() {
        parent::__construct("staff_list");
    }
    public static function IsLogin() {
        if (!isset($_COOKIE["myid"])) {
            header("location:/login.php");
        }
    }
}
?>