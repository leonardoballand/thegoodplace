<?php

// Générer un token
// Ajouter les nouveaux champs activated (BOOL) et token_verif (VARCHAR 255) dans la table users
// Enregistrer le token en base
// Envoyer le mail avec lien token
// Gérer l'accès au lien
// Validation du token + email
// Go !

$email = checkInput("email");
$token = checkInput("token");

// cas 2 : l'utilisateur a cliqué sur le lien de validation dans l'email
// email & token
if ($email != '' && $token != '') {
    
    // On doit vérifier si le token correspond bien à l'email de l'utilisateur
    // On vérifie directement avec une requête SQL si un utilisateur existe ayant l'email ET le token
    $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

    $sth = $dbh->prepare("SELECT id FROM users WHERE email = :email AND token_verif = :token LIMIT 1;");

    if ($sth->execute(
            array(
            ':email' => $email,
            ':token' => $token
            )
        )
    ) {
        // On récupère les infos du user pour avoir l'id
        $user = $sth->fetch();

        $sth = $dbh->prepare("UPDATE users SET activated = true WHERE id = :id");
        
        // On met à jour le champ 'activated' de l'utilisateur
        $sth->execute(array(
            ':id' => $user['id']
        ));

        // Si l'activation du compte est ok, on le redirige vers la page connexion
        if ($sth->rowCount() > 0) {
            Header('Location: connexion.php');
        } else {
            // La mise à jour de l'activation n'a pas pu être faite
        }
        
    } else {
        // Avertir l'utilisateur lien périmé ou invalide
    }



} else {
    // cas 1 : redirection suite à l'inscription

}

?>