<?php

// On fait expirer le cookie pour le supprimer
setcookie("thegoodplace_SESSIONID", $sessionID, -1, "/");

// On détruit la session
session_start();
session_destroy();

// On redirige l'utilisateur sur la page de connexion
header('Location: connexion.php');

?>