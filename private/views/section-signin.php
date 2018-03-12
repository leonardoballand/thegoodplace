<section id="signin" class="container-fluid">
    <div class="row justify-content-center">
        <h1 class="display-4 text-primary">Créer un compte</h1>
    </div>
    <div class="row justify-content-center">
      <div class="col-s12 col-m6 col-l4">
        <div class="message-feedback">
            <?php displayFeedback(); ?>
        </div>
        <form action="#form-signin" method="POST" class="border">
            
            <div class="form-group">
                <label for="name">Quel est votre nom et prénom ?</label>
                <input type="text" class="form-control" name="name" id="name" />
            </div>

            <div class="form-group">
                <label for="email">Quel est votre email ?</label>
                <input type="email" class="form-control" name="email" id="email" />
            </div>

            <div class="form-group">
                <label for="password">Quel est votre mot de passe ?</label>
                <input type="password" class="form-control" name="password" id="password" />
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirmez le mot de passe que vous avez choisi</label>
                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" />
            </div>

            <input hidden name="idForm" value="signin">

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg btn-block">Je m'inscris</button>
            </div>
            <div class="row justify-content-center">
                <a href="connexion.php">Déjà un compte ?</a>
            </div>
        </form>
      </div>
    </div>
</section>