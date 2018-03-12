<section id-"ajout" class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-4 ajout-title-wrapper">
            <h1 class="display-4 text-primary">Publiez votre annonce</h1>
        </div>
        <div class="col-sm-12 col-md-8">
            <div class="message-feedback">
                <?php displayFeedback(); ?>
            </div>
            <form enctype="multipart/form-data" action="#form-ajout" method="POST">
                <div class="form-group">
                    <label for="title">Donnez un titre à votre annonce</label>
                    <input type="text" class="form-control" name="title" id="title" />
                </div>
                <div class="form-group">
                    <label for="content">Que vendez-vous ?</label>
                    <textarea name="content" class="form-control" id="" cols="30"></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Quel est le prix ?</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="price" id="price" />
                        <div class="input-group-append">
                            <span class="input-group-text">€</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="picture_url">Upload d'une photo</label>
                    <input type="file" name="picture_url" id="picture_url">
                </div>

                <input type="hidden" name="MAX_FILE_SIZE" value="30000000000000000000000000000000000">

                <input hidden name="idForm" value="ajout">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Ajouter une annonce</button>
                </div>
            </form>
        </div>
    </div>
</section>