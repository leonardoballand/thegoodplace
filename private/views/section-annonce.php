<?php 
// on charge le fichier controlleur
// qui s'occupe de préparer les données pour la vue
require_once('private/controllers/annonces/annonce.php');
?>

<?php
    if (isset($annonce)) {
?>
    <section id="annonce-<?php echo $annonce['id'] ?>" class="annonce">
        <img src="<?php echo $annonce['picture_url'] ?>" alt="image annonce" class="img-fluid" />
        <!-- titre -->
        <h1 class="annonce-title text-secondary">
            <?php echo $annonce['title'] ?>
        </h1>
        <!-- date/auteur -->
        <small>Publié le <?php echo date('d/m/Y à H:i', strtotime($annonce['created_at'])) ?> par <?php echo $annonce['name'] ?></small>
        <!-- contenu -->
        <div class="annonce-content">
            <?php echo $annonce['content'] ?>
        </div>
        <!-- prix -->
        <span class="annonce-price badge badge-secondary">
            <?php echo $annonce['price'] ?> €
        </span>
        <!-- Si l'annonce n'est pas celle de l'utilisateur, on affiche un bouton pour contacter le vendeur -->
        <?php if (isset($canSendMessage)) { ?>
            <a class="btn btn-primary btn-block" href="annonce-contact.php?sellerid=<?php echo $annonce['user_id'] ?>">Envoyer un message</a>
        <?php } ?>
    </section>
<?php
    } else {
    ?>
        <div class="text-center">
            <h1 class="display-4 text-secondary">Cette annonce n'existe pas !</h1>
            <a href="annonces.php" class="btn btn-lg btn-secondary">Retourner à la liste des annonces</a>
        </div>
    <?php
    }
?>
</div>