<?php require_once('private/controllers/dashboard/liste-messages.php'); ?>

<section id="inbox">

  <div class="jumbotron jumbotron-fluid text-center">
      <h1 class="display-4 text-primary">Vos messages</h1>
      <p class="lead">Retrouvez l'historique de tous les messages de vos visiteurs</p>
  </div>

  <div class="container">
    <div class="row justify-content-center">

<?php
  if (isset($messages)) { ?>

      <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <td class="text-primary">Nom</td>
          <td class="text-primary">Email</td>
          <td class="text-primary">Message</td>
          <td class="text-primary">Date</td>
          <td class="text-primary">Status</td>
        </tr>
      </thead>
      <tbody>
<?php
    forEach($messages as $message)
    {
?>
      <tr>
        <td><strong><?php echo $message['name'] ?></strong></td>
        <td><?php echo $message['email'] ?></td>
        <td><?php echo substr($message['message'], 0, 150) ?>...</td>
        <td><?php echo $message['date_message'] ?></td>
        <td class="text-center">
          <i class="fa fa-envelope statusColor <?php echo $message['status_color'] ?>"></i>
        </td>
      </tr>
<?php
    }
?>
        </tbody>
      </table>
<?php } else { ?>
  <p class="lead">Vous n'avez encore aucun message dans votre historique</p>
<?php } ?>
    </div>
  </div>
</section>