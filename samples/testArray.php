<?php

    // Tester si une valeur est dans un tableau
    // avec in_array() http://php.net/manual/fr/function.in-array.php
    $ext = 'jpg';
    $tab = array('jpg', 'pdf', 'png', 'gif');

    if (in_array($ext, $tab)) {
        echo 'ok';
    } else {
        echo 'not ok';
    }

?>