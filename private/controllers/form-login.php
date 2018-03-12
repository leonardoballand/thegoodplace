<?php

    require_once('private/init.php');

    $feedback = 'En cours de traitement...';

    // on vérifie nos paramètres nécessaires
    $email = checkInput("email");
    $password = checkInput("password");
    $rememberme = checkInput("rememberme"); // on vérifie si l'utilisateur a coché la case "Rester connecté"

    // si on a bien un email bien formaté et un mot de passe
    if ($password != '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);

        $sth = $dbh->prepare('SELECT * FROM users WHERE email = ? LIMIT 1'); // on prépare notre requête
        $sth->execute(array($email)); // on l'exécute en lui passant notre email

        // Si on récupère bien un utilisateur
        if ($sth->rowCount() > 0) {
            $user = $sth->fetch();
            
            // on ajoute une étape en plus dûe à la validation du compte par email
            // si l'utilisateur qui tente de se connecter à déjà activé son compte
            if ($user['activated']) {

                $hashPassword = $user['password']; // on compare les deux mots de passe
    
                // Si le mot de passe correspond au hash de la BDD, l'utilisateur est connecté
                if (password_verify($password, $hashPassword)) {
                    initSession($user); // on initialise la session
    
                    if ($rememberme != '') { // si l'utilisateur a coché la checkbox "Rester connecté"
                       persistSession(); // on persiste la session
                    }
    
                    header('Location: dashboard.php');
                } else {
                    $feedback = 'Mot de passe incorrect !';
                }

            } else {
                // sinon on le redirige vers la page d'activation du compte
                header('Location: validation.php');
            }
    
        } else {
            // sinon on redirige vers la page de connexion
            // Header('Location: connexion.php');
            $feedback = 'Aucun compte trouvé pour cette adresse e-mail.';
        }

        $dbh = null;
        
    } else {
         // sinon on redirige vers la page de connexion
         // Header('Location: connexion.php');
         $feedback = 'Veuillez vérifier votre formulaire.';
    }

?>