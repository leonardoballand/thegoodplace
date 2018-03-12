<?php

    require_once('private/init.php');

    // On vérifie les paramètres nécessaires à l'exécution du code
    $title = checkInput('title');
    $content = checkInput('content');
    $price = checkInput('price');
    $email = checkInput('email');

    // Si c'est ok, on peut commencer à travailler
    if ($title != '' && $content != '' && $price != '' && $email != '') {

        $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

        $sth = $dbh->prepare('SELECT id FROM users WHERE email = ? LIMIT 1'); // on prépare notre requête
        $sth->execute(array($email)); // on l'exécute en lui passant notre email

        if ($sth->rowCount() > 0) { // Si l'utilisateur existe

            $user = $sth->fetch(); // on stocke les valeurs de l'entrée
    
            $user_id = $user['id']; // on récupère l'id de l'utilisateur
    
            // on prépare notre requête d'insertion d'annonce
            $sth = $dbh->prepare('INSERT INTO annonces (title, content, price, user_id)
                VALUES (:title, :content, :price, :user_id)');
    
            $sth->bindParam(':title', $title);
            $sth->bindParam(':content', $content);
            $sth->bindParam(':price', $price);
            $sth->bindParam(':user_id', $user_id); // on lui passe l'id de l'utilisateur (foreign key)
    
            $sth->execute(); // on exécute la requête

            // et on redirige vers la page dashboard
            header('Location: ../dashboard.php');
        } else {
            // Sinon on redirige vers la page connexion.php
            // header('Location: ../connexion.php');
            $feedback = 'Aucun utilisateur trouvé avec cette adresse e-mail !';
        }

        $dbh = null;
        
    } else {
        // Sinon on redirige vers la page connexion.php
        // header('Location: ../connexion.php');
        $feedback = 'Veuillez vérifier les informations de votre annonce.';
    }


?>