<?php

mysql_connect($mysql_host, $mysql_login, $mysql_password);
mysql_select_db('NextTripTicket');

function	get_tickets() {
  $query = 'SELECT * FROM tickets WHERE picture<>\'\'';
  //  $query = 'SELECT t.*, c.Country, cc.name AS currency, c.AccentCity AS city_name, tt.name AS type_name, tt.details AS type_details FROM tickets AS t JOIN cities AS c JOIN tickets_types AS tt JOIN currencies AS cc WHERE t.city=c.id AND t.currency=cc.id AND tt.id=t.type AND user="'.protect($user).'" ORDER BY c.Country, c.AccentCity';
  if (!($result = mysql_query($query)))
    return 0;
  while ($ticket = mysql_fetch_assoc($result)) {
    $tickets[] = $ticket;
  }
  return $tickets;
}

$tickets = get_tickets();

if (empty($tickets)) { ?>
<div class="alert alert-error">No tickets found, sorry :(</div>
<?php } else { ?>
<div id="myslides">
  <?php foreach ($tickets as $ticket) { ?>
  <a href="tickets?ticket=<?= $ticket['id'] ?>"><img src="<?= $ticket['picture'] ?>" alt="ticket"></a>
  <?php } ?>
</div>
<?php } ?>





