<?php
include_once(root . '/library/mysqlhelper.php');
class ArticleAdvertListView extends MySqlHelper {
    public function __construct() {
        parent::__construct("article_advert_list_view");
    }
}
?>