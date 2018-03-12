<?php

// On fait nos vérifications habituelles
$sellerID = checkInput("sellerid");
$sellerEmail = checkInput("sellerEmail");
$sellerName = checkInput("sellerName");
$message = checkInput("message");

// Si on a bien l'id d'un vendeur on peut continuer, sinon on avertit la vue que l'utilisateur est inconnu pour qu'elle affiche un message d'erreur
if ($sellerID != '') {
  $notFound = false;

  // on va récupérer les infos du vendeur
  $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);
  $sth = $dbh->prepare('SELECT name, email FROM users WHERE id = ?');
  $sth->execute(array($sellerID));

  $seller = $sth->fetch();

  // on vérifie si le formulaire a été soumis en vérifiant si le tableau assoc $_POST contient des clés/valeurs
  if (count($_POST) > 0) {
    // alors on traite le formulaire
    $feedback = 'En cours de traitement...';

    // si on a bien toutes les informations nécessaires pour traiter le formulaire
    if ($sellerEmail != '' && $sellerName != '' && $message != '') {

      // on récupère les infos de l'acheteur (le user qui est connecté) depuis la session (j'ai au préalable rajouté dans notre fonction initSession() ces informations)
      $buyerName = $_SESSION['name'];
      $buyerEmail = $_SESSION['email'];

      // on stocke dans la base de donnée le message, il aura le statut "en attente" par défaut
      $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);
      $sth = $dbh->prepare('INSERT INTO messages (name, email, message) VALUES (:name, :email, :message);');
      $sth->execute(array(
        ":name" => $buyerName,
        ":email" => $buyerEmail,
        ":message" => $message
      ));
      
      if ($sth > 0) {

        $messageID = $dbh->lastInsertId(); // on récupère l'id du message pour pouvoir le mettre à jour ensuite

        // on essaye d'envoyer le mail au format HTML
        if (sendEmailHTML($buyerName, $buyerEmail, $sellerEmail, $message)) {

          // si c'est ok, on reset les messages d'erreur, et on va mettre à jour le statut du message 
          $feedback = '';

          $sth = $dbh->exec("UPDATE messages SET status = 'envoyé' WHERE id = $messageID");

          if ($sth > 0) {
            header("location:annonces.php");
          }

        } else {

          // si le mail n'a pas été envoyé, on va mettre à jour le statut du message
          $sth = $dbh->exec("UPDATE messages SET status = 'erreur' WHERE id = $messageID");
          $feedback = 'Une erreur est survenue. Veuillez réessayer plus tard.';

        }

        $dbh = null; // on oublie pas de fermer la connexion à la BDDs
      } else {
        // Si on a pas réussi à stocker le message dans notre base de donnée, on avertit l'utilisateur que le serveur a rencontré une erreur
        $feedback = 'Une erreur est survenue, réessayez plus tard !';
      }


    } else {
      // Si on a pas toutes les informations nécessaires au traitement du formulaire, on avertit l'utilisateur de le corriger
      $feedback = 'Veuillez vérifier les informations du formulaire';
    }
  }
  
} else {
  // Si l'id du vendeur est manquant dans la requête GET, on avertit la vue qu'on veut afficher le message d'erreur
  $notFound = true;
}

?>