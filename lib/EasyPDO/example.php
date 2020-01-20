<?php

require 'easypdo.php';

$a = new EasyPDO();
$a->connect('localhost', 'birebirilgi', 'root', '');
$dbPages = $a->table('pages');
print_r($dbPages->select("WHERE `url_name`= ?", ['url2'])->fetch());
if (!empty($sorgu)) {
    $name = $sorgu['name'];
    $keywords = $sorgu['keywords'];
    $description = $sorgu['description'];
    $author = $sorgu['author'];
    echo $sorgu['content'];
}
