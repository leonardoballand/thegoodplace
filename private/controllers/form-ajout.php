<?php

    require_once('private/init.php');

    // On vérifie les paramètres nécessaires à l'exécution du code
    $title = checkInput('title');
    $content = checkInput('content');
    $price = checkInput('price');
    $file = checkFile('picture_url');
    $user_id = getUserID(); // on récupère l'id depuis la session

    // debug($file);

    // Si c'est ok, on peut commencer à travailler
    if ($title != '' && $content != '' && $price != '' && $user_id != '' && $file != '') {

        $picture_url = $file['picture_url'];

        $uploadFolder = 'public/uploads/';
        $filePath = $uploadFolder . basename($picture_url['name']);

        // on vérifie le type du fichier basé sur l'extension
        $allowedTypes = array('png', 'jpg', 'jpeg', 'gif');
        $fileExt = strtolower(pathinfo($picture_url['name'], PATHINFO_EXTENSION));

        // si l'extension du fichier est autorisée
        if (in_array($fileExt, $allowedTypes)) {
            
            // vérifier la taille
            // on récupère la taille du fichier (celui placé dans le répertoire temporaire)
            $checkSize = getimagesize($picture_url['tmp_name']);

            // si sa taille est supérieure à 0, on peut dire que le fichier est valide
            if ($checkSize > 0) {

                // on va déplacer l'image vers le répertoire définitif
                if (move_uploaded_file($picture_url['tmp_name'], $filePath)) {

                    // Le fichier a bien été déplacé
                    $picture_url = 'public/uploads/' . $picture_url['name'];

                } else {
                    // Problème lors du déplacement du fichier
                }
            }
        }

        $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

        // on prépare notre requête d'insertion d'annonce
        $sth = $dbh->prepare('INSERT INTO annonces (title, content, picture_url, price, user_id)
            VALUES (:title, :content, :picture_url, :price, :user_id)');

        $sth->bindParam(':title', $title);
        $sth->bindParam(':content', $content);
        $sth->bindParam(':picture_url', $picture_url);
        $sth->bindParam(':price', $price);
        $sth->bindParam(':user_id', $user_id); // on lui passe l'id de l'utilisateur (foreign key)

        $sth->execute(); // on exécute la requête

        // et on redirige vers la page dashboard
        header('Location: dashboard.php');

        $dbh = null;
        
    } else {
        // Sinon on redirige vers la page connexion.php
        // header('Location: ../connexion.php');
        $feedback = 'Veuillez vérifier les informations de votre annonce.';
    }


?>