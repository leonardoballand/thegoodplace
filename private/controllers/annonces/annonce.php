<?php

require_once('private/init.php');

$annonceID = checkInput("id"); // on vérifie si on a utilisé une requête GET
$annonceID = intval($annonceID);

$action = checkInput("action");

if ($action != '' && $action == "delete" && $annonceID) {
    // on passe en mode suppression
    $res = deleteAnnonce($annonceID);

    if ($res > 0) {
        header('Location: annonces.php');
    } else {
        // une erreur blabla
    }
}

if ($annonceID != 0) {
    $req = "SELECT *, annonces.id AS id, annonces.user_id AS user_id
        FROM users
        INNER JOIN annonces ON annonces.user_id = users.id
        WHERE annonces.id = ?;
    ";
    
    $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);
    
    $sth = $dbh->prepare($req);
    $sth->execute(array($annonceID));
    
    // si on a des résultats, on affiche la liste
    if ($sth->rowCount() > 0) {
        $annonce = $sth->fetch();

        // Si l'annonce appartient à l'utilisateur, on n'affiche pas le bouton pour envoyer le message
        if ($annonce['user_id'] != $_SESSION['userid']) {
            $canSendMessage = true;
        }
    }
}

?>