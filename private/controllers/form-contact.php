<?php

require_once('private/init.php');

$feedback = 'En cours de traitement...'; // Debug

// 1. Récupérer les informations du formulaire contact
// 2. Vérifier les informations du formulaire contact
$name = checkInput("name");
$email = checkInput("email");
$message = checkInput("message");

if ($name != '' && $message != ''
    && $email != '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // 3. Envoyer en base de donnée ces informations
        $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);
        $sth = $dbh->prepare("INSERT INTO messages (name, email, message) VALUES (:name, :email, :message) ");
        
        if($sth->execute(array(
            ":name" => $name,
            ":email" => $email,
            ":message" => $message
        ))) {

            // 4. Préparer l'email (formatage et préparation des données)
            // 5. Envoyer l'email
            // (On va utiliser une fonction pour préparer l'email et l'envoyer
            // afin de garder clair et propre notre code controlleur)
            if (sendEmail($name, $email, $message)) {
                $feedback = '';
            } else {
                $feedback = "Nous n'avons pas réussi à envoyer votre message. Veuillez réessayer après-demain !";
            }

        } else {
            $feedback = 'Une erreur est survenue, merci de réessayer plus tard.';
        }

        $dbh = null; // on oublie pas de fermer la connexion à la BDD

} else {
    $feedback = 'Merci de saisir toutes les informations requises.';
}


// (suite optionnelle)
// 6.1 Rajoutez un champ dans la table messages "envoyé" (valeur par défaut false)
// 6.2 Si le message est envoyé, passer la valeur du champ "envoyé" à true

?>