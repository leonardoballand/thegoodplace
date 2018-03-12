<?php

require_once('private/init.php');
require_once('private/models/database.php');

$keyword = checkInput("keyword");

if ($keyword != '') {
    $annonces = getAnnoncesByKeyword($keyword);
}

?>