<!DOCTYPE html>
<html lang="fr-fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TheGoodPlace</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/styles.css" />
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/goodplace">TheGoodPlace</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
<?php if (isLogged()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="annonces.php">Voir les annonces</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ajout.php">Ajouter une annonce</a>
                    </li>
<?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contactez-nous</a>
                    </li>
                </ul>
                <form action="search.php" class="form-inline" method="GET">
                    <input type="text" name="keyword" class="form-control">
                    <input type="hidden" name="idForm" value="search">
                    <button class="btn btn-outline-primary" type="submit">Chercher</button>
                </form>
                <ul class="navbar-nav">
<?php if (!isLogged()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">Se connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inscription.php">S'inscrire</a>
                    </li>
<?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><i class="fa fa-tachometer"></i> Tableau de bord</a>
                    </li>
<?php if (isAdmin()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="messages.php"><i class="fa fa-inbox"></i> Boîte de réception</a>
                    </li>
<?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> </a>
                    </li>
<?php } ?>
                </ul>
            </div>
        </nav>
    </header>