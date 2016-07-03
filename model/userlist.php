<?php
include_once(root.'/library/mysqlhelper.php');
class UserList extends MySqlHelper {
    public function __construct() {
        parent::__construct("user_list");
    }
}
?>