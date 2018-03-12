<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 class="display-4 text-primary text-center">Envoyez-nous un message</h1>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="message-feedback">
                <?php displayFeedback(); ?>
            </div>
            <form action="#form-contact" method="POST">
                
                <div class="form-group">
                    <label for="name">Comment vous appelez-vous ?</label>
                    <input type="text" class="form-control" name="name" id="name" required />
                </div>
    
                <div class="form-group">
                    <label for="email">Quel est votre email ?</label>
                    <input type="email" class="form-control" name="email" id="email" required />
                </div>

                <div class="form-group">
                    <label for="message">Que voulez-vous nous dire ?</label>
                    <textarea name="message" id="message" cols="30" class="form-control" required></textarea>
                </div>
    
                <input hidden name="idForm" value="contact">
    
                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-block btn-primary">Envoyer le message</button>
                </div>
            </form>
        </div>
    </div>
</div>