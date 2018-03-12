<?php

require_once('private/models/database.php');

// On va simplement chercher tous les messages dans la base de données
$data = getAllMessages();

$messages = array();

forEach($data as $message)
{
    $msg = $message;

        // On définit une classe CSS de manière dynamique
    $msg['status_color'] = getClassStatus($message['status']);

    // Si le message date du même jour, on affiche seulement l'heure, sinon on affiche la date (jour/mois)
    $msg['date_message'] = isToday($message["created_at"]) ? date('H:i', strtotime($message["created_at"])) : date('d/m', strtotime($message["created_at"]));

    $messages[] = $msg;

}

?>