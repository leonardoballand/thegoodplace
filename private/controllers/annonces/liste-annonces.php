<?php

require_once('private/init.php');

$userID = checkInput("fromid"); // on vérifie si on a utilisé une requête GET pour afficher des annonces d'un user en particulier
$page = checkInput("page"); // on vérifie si on a utilisé une requête GET pour afficher une page en particulier

$page = $page == '' ? 1 : $page; // on démarre toujours à la page une même si on a pas spécifié de page dans la requête GET (?page=)

$nbAnnoncesPerPage = 5; // on définit le nombre maximum d'annonces par page
$newIndex = $nbAnnoncesPerPage * ($page - 1); // on définit l'index de l'offset
$minPage = 1; // on définit le nombre minimum de page

$req = 'SELECT COUNT(*) AS nbAnnonces FROM annonces';

// Si on affiche les annonces pour un utilisateur, on veut seulement le total des annonces de l'utilisateur
if ($userID != '') {
    $req .= " WHERE annonces.user_id = ?";
}

$dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);
$sth = $dbh->prepare($req);

// Si on affiche les annonces pour un utilisateur, on a besoin de fournir la valeur pour le marqueur
if ($userID != '') {
    $sth->execute(array($userID));
} else {
    $sth->execute();
}

$totalAnnonce = $sth->fetch(); // on récupère le nombre total d'annonces

// on définit le nombre maximum de page à afficher
$maxPage = ceil($totalAnnonce['nbAnnonces'] / $nbAnnoncesPerPage);

// on définit le numéro de page précédente
$pageIndexPrev = $page > 1 ? $page - 1 : null;

// on définit le numéro de page suivante
$pageIndexNext = ($page < $maxPage) && ($totalAnnonce['nbAnnonces'] > $nbAnnoncesPerPage) ? $page + 1 : null;

$req = "SELECT *
    FROM users
    INNER JOIN annonces
        ON users.id = annonces.user_id";

$fromid = $userID != '' ? "fromid=$userID&"  : "";

if ($userID != '') {
    // on prépare un tableau avec les annonces d'un utilisateur en particulier
    $req .= " WHERE annonces.user_id = $userID";
}

$req .= " LIMIT $nbAnnoncesPerPage OFFSET $newIndex;"; // on oublie pas de fermer notre requête

$dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

$stmt = $dbh->query($req);

// si on a des résultats, on affiche la liste
// sinon on affiche un message 'Aucune annonce'
if ($stmt->rowCount() > 0) {
    $annonces = $stmt->fetchAll();
}

?>