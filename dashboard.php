<?php
/**
* Template de la page Dashboard
*/

?>

<?php require_once('private/init.php'); ?>

<?php protectPage(); ?>

<?php include('private/views/includes/header.php'); ?>

<main>
    <?php include('private/views/section-dashboard.php'); ?>
</main>


<?php include('private/views/includes/footer.php'); ?>