<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 class="display-4 text-primary text-center">Connectez-vous</h1>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="message-feedback">
                <?php displayFeedback(); ?>
            </div>
            <form action="#form-login" method="POST">
                
                <div class="form-group">
                    <label for="email">Quel est votre email ?</label>
                    <input type="text" class="form-control" name="email" id="email" />
                </div>
    
                <div class="form-group">
                    <label for="password">Quel est votre mot de passe ?</label>
                    <input type="password" class="form-control" name="password" id="password" />
                </div>

                <div class="form-group">
                    <input type="checkbox" name="rememberme" id="rememberme">
                    <label for="rememberme">Rester connecté</label>
                </div>
    
                <input hidden name="idForm" value="login">
    
                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-block btn-primary">Je me connecte</button>
                </div>
                <div class="row justify-content-center">
                    <a href="inscription.php">Pas encore de compte ?</a>
                </div>
            </form>
        </div>
    </div>
</div>