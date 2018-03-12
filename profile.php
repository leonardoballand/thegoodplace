<?php
/**
 * Template de la page Profile
 */

?>

<?php require_once('private/init.php'); ?>

<?php protectPage(); ?>

<?php include('private/views/includes/header.php'); ?>

<main>
    <?php include('private/views/dashboard/section-profile.php'); ?>
</main>


<?php include('private/views/includes/footer.php'); ?>