<?php require_once('private/controllers/form-annonce-contact.php'); ?>

<div class="container">
    <div class="row justify-content-center">
<?php
    // Si l'id de l'utilisateur est fourni, on affiche le formulaire
    if (!$notFound) {
?>
        <div class="col-12">
            <h1 class="display-4 text-primary text-center">Envoyez un message au vendeur</h1>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="message-feedback">
                <?php displayFeedback(); ?>
            </div>
            <form action="#form-annonce-contact" method="POST">

                <div class="form-group">
                    <textarea name="message" id="message" cols="30" rows="10" class="form-control" required>Bonjour <?php echo $seller['name'] ?>, je suis intéressé par votre annonce, est-elle toujours disponible ?</textarea>
                </div>

                <input hidden name="sellerName" value="<?php echo $seller['name'] ?>">

                <input hidden name="sellerEmail" value="<?php echo $seller['email'] ?>">
    
                <input hidden name="idForm" value="annonce-contact">
    
                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-block btn-primary">Envoyer le message</button>
                </div>
            </form>
        </div>
<?php
    // Sinon on affiche un message d'erreur
    } else {
?>
    <div class="col-12">
      <h1 class="display-4 text-secondary text-center">Oooooops! Cette annonce n'existe plus.</h1>
      <p class="lead text-center"><a href="javascript:history.go(-1)">Retour à la page précédente</a></p>
    </div>
<?php } ?>
    </div>
</div>