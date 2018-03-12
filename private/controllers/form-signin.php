<?php

    require_once('private/init.php');

    // on vérifie nos paramètres nécessaires
    $name = checkInput("name");
    $email = checkInput("email");
    $password = checkInput("password");
    $confirmPassword = checkInput("confirmPassword");

    // si on a bien un nom, un email bien formaté et un mot de passe bien confirmé
    if ($name !== '' && $password != '' && $confirmPassword != ''
        && filter_var($email, FILTER_VALIDATE_EMAIL)
          && $password == $confirmPassword) {
        
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

        $sth = $dbh->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password);'); // on prépare notre requête
        $sth->execute(array(
          ':name' => $name,
          ':email' => $email,
          ':password' => $hashPassword
        )); // on l'exécute en lui passant nos informations de formulaire

        // Si on récupère bien un utilisateur
        if ($sth->rowCount() > 0) {

          $userId = $dbh->lastInsertId(); // on récupère l'id de la dernière entrée insérée dans la table

          // on initialise la session comme pour la connexion
          // initSession($userId, $name, $email);

          // on génère un token de validation
          $token = generateToken();

          // on prépare notre requête pour mettre à jour l'entrée utilisateur dans la base de donnée
          $sth = $dbh->prepare("UPDATE users SET token_verif = :token WHERE id = :id;");

          // on met à jour l'utilisateur avec le token
          $sth->execute(array(
            ":id" => $userId,
            ":token" => $token
          ));

          if ($sth->rowCount() > 0) {

            // on envoit notre email de validation
            if(sendValidationEmail($email, $token)) {
              // on redirige vers la page validation
              Header('Location: validation.php');
            } else {
              $feedback = 'Impossible de vous envoyer l\'email de validation. Merci de réessayer la semaine prochaine.';
            }

          }

        } else {
          // sinon on redirige vers la page de connexion
          $feedback = "Une erreur est survenue. Merci de réessayer";
        }

        $dbh = null;
        
    } else {
        // sinon on redirige vers la page de connexion
        $feedback = "Merci de vérifier votre formulaire.";
    }

?>