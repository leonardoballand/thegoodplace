<div class="container">
    <div class="row justify-content-center jumbotron jumbotron-fluid">
        <h1 class="display-4 text-center text-primary">Vous êtes connecté à votre dashboard</h1>
    </div>

    <div class="row">
        <?php include('dashboard/section-stats.php'); ?>

        <div class="col align-self-end">
            <div class="card col-s6">
                <div class="card-header">
                    Ajouter une nouvelle annonce
                </div>
                <div class="card-body">
                    <?php include('section-ajout.php'); ?>
                </div>
            </div>
        </div>
    </div>

</div>