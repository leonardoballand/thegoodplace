<div id="annonces" class="container">
    <div class="row">
<?php
    require_once('private/controllers/annonces/search-annonces.php');
    
    if (isset($annonces) && count($annonces) > 0) {
        forEach($annonces as $annonce)
        {
?>
    <div class="col-4">
        <div class="card" id="annonce-<?php echo $annonce['id'] ?>">
            <img src="<?php echo $annonce['picture_url'] ?>" alt="image de l'annonce" class="card-img-top">
            <div class="card-body">
                <h5 class="card-title text-primary">
                    <?php echo $annonce['title'] ?>
                </h5>
                <p class="card-text">
                    <small class="muted-text">Publié le <?php echo date('d/m/Y à H:i', strtotime($annonce['created_at'])) ?> par <?php echo $annonce['name'] ?></small>
                </p>
                <p class="card-text">
                    <?php echo $annonce['content'] ?>
                </p>
                <p class="text-right">
                    <?php echo $annonce['price'] ?> €
                </p>
                <a href="annonce.php?id=<?php echo $annonce['id'] ?>" class="btn btn-primary">Voir</a>
                <?php if (isAdmin()) { ?>
                <a href="annonce.php?id=<?php echo $annonce['id'] ?>&action=delete" class="btn btn-danger">Supprimer</a>
                <?php } ?>
            </div>
        </div>
    </div>
<?php
        }
?>
    </div>
    <div class="row justify-content-center">
        <nav>
        <?php
            if (isset($pageIndexPrev)) {
        ?>
                <a href="annonces.php?<?php echo $fromid ?>page=<?php echo $pageIndexPrev ?>">
                    <i class="fa fa-arrow-left"></i>
                </a>
        <?php
            }
            if (isset($pageIndexNext)) {
        ?>
                <a href="annonces.php?<?php echo $fromid ?>page=<?php echo $pageIndexNext ?>">
                <i class="fa fa-arrow-right"></i>
                </a>
        <?php
            }
        ?>
        </nav>
    </div>
<?php
    } else {
?>
        <div class="text-center">
            <h1 class="display-1 text-secondary">Aucune annonce disponible !</h1>
            <a href="ajout.php" class="btn btn-lg btn-secondary">Soyez le premier à publier une annonce !</a>
        </div>
<?php
    }
?>
</div>