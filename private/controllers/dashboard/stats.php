<?php

    require_once('private/init.php');

    $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

    $statReq1 = 'SELECT COUNT(*) AS nbAnnonces FROM annonces';
    $statReq2 = 'SELECT ROUND(AVG(price)) AS avgPrice FROM annonces';

    $stmt = $dbh->query($statReq1);

    $res1 = $stmt->fetch();
    $nbAnnonces = $res1['nbAnnonces'];

    $stmt->closeCursor();

    $stmt = $dbh->query($statReq2);

    $res2 = $stmt->fetch();
    $avgPrice = $res2['avgPrice'];

    $avgPrice == NULL ? $avgPrice = 0 : $avgPrice;

    $dbh = null;

?>