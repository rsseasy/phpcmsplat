<?php
include_once(root . '/library/mysqlhelper.php');
class ArticleList extends MySqlHelper {
    public function __construct() {
        parent::__construct("article_list");
    }
}
?>