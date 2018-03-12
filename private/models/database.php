<?php

/**
 * FICHIER MODELE SERVANT A COMMUNIQUER AVEC LA BDD DIRECTEMENT
 * DOIT ÊTRE APPELE PAR UN FICHIER CONTROLLEUR
 */

 /**
  * Récupère tous les messages 
  * @return Array - Tableau contenant tous les messages
  */
 function getAllMessages()
 {
    $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

    $sth = $dbh->query("SELECT * FROM messages ORDER BY created_at DESC;");

    $dbh = null;

    return $sth->fetchAll();
 }

 /**
  * Supprime une annonce par son ID
  * @param Int - id de l'annonce
  * @return Int - nombre d'entrées supprimées
  */
 function deleteAnnonce($id)
 {
    $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

    $sth = $dbh->prepare("DELETE FROM annonces WHERE id = :id;");
    $sth->execute(array(
        ':id' => $id
    ));

    $dbh = null;

    return $sth->rowCount();
 }

 /**
  * Récupère toutes les annonces 
  * @return Array - Tableau contenant toutes les annonces
  */
 function getAllAnnonces() {
    $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

    $sth = $dbh->query("SELECT * FROM annonces ORDER BY created_at DESC;");

    $dbh = null;

    return $sth->fetchAll();
 }

 /**
  * Récupère toutes les annonces contenant le mot-clé spécifié 
  * @return Array - Tableau contenant toutes les annonces correspondantes
  */
 function getAnnoncesByKeyword($keyword)
 {
    $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

    $sth = $dbh->prepare("SELECT *, annonces.id AS id 
        FROM annonces
        INNER JOIN users
        ON annonces.user_id = users.id
        WHERE title LIKE :keyword
        OR content LIKE :keyword"
    );

    $sth->execute(array(
        ':keyword' => "%$keyword%"
    ));

    $dbh = null;

    return $sth->fetchAll();
 }
 
?>