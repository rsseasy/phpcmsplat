<?php
include_once(root . '/library/mysqlhelper.php');
class ArticleAdvertList extends MySqlHelper {
    public function __construct() {
        parent::__construct("article_advert_list");
    }
}
?>