<?php require_once('private/controllers/dashboard/stats.php') ?>

<section id="dashboard-stats" class="card" style="width: 18rem;">
  <img class="card-img-top" src="public/img/stats.jpg" alt="Statistiques de TheGoodPlace">
  <div class="card-body">
    <h5 class="card-title">Statistiques générales</h5>
    <p class="card-text">Retrouvez ici les principales statistiques générées automatiquement par TheGoodPlace.</p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Nombre d'annonces sur le site : <?php echo $nbAnnonces ?></li>
    <li class="list-group-item">Prix moyen des annonces : <?php echo $avgPrice ?> €</li>
  </ul>
  <div class="card-body">
    <a href="annonces.php?fromid=<?php echo getUserID() ?>" class="card-link">Mes annonces</a>
    <a href="profile.php" class="card-link">Editer mon profil</a>
  </div>
</section>