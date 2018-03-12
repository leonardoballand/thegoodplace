<?php

    session_start();

    error_reporting(-1);

    require_once('controllers/functions.php');
    require_once('models/database.php');

    define('USER', 'root');
    define('PASSWORD', '');
    define('DSN', 'mysql:host=localhost;dbname=thegoodplace;charset=utf8');
    define('DBOPTIONS', array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));

    define('ROOT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/goodplace');

    $feedback = '';

    $idForm = checkInput("idForm");

    if ($idForm != '') {

        $pathFile = "private/controllers/form-$idForm.php";

        if (is_file($pathFile)) {
            require_once($pathFile);
        }
    }


?>