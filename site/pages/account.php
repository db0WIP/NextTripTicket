<?php

mysql_connect($mysql_host, $mysql_login, $mysql_password);
mysql_select_db('NextTripTicket');

function protect($string) {
  return (htmlspecialchars(stripslashes($string)));
}

$r = include_once('login.php');
if (!$r)
  return;

check_form_edit($_POST);
check_form_delete($_POST);

function	get_tickets($user) {
  $query = 'SELECT t.*, c.Country, cc.name AS currency, c.AccentCity AS city_name, tt.name AS type_name, tt.details AS type_details FROM tickets AS t JOIN cities AS c JOIN tickets_types AS tt JOIN currencies AS cc WHERE t.city=c.id AND t.currency=cc.id AND tt.id=t.type AND user="'.protect($user).'" ORDER BY c.Country, c.AccentCity';
  if (!($result = mysql_query($query)))
    return 0;
  while ($ticket = mysql_fetch_assoc($result)) {
    $tickets[] = $ticket;
  }
  return $tickets;
}

function	get_available_cities() {
  if (!($result = mysql_query('SELECT c.* FROM cities_details AS d JOIN cities AS c WHERE d.id=c.id ORDER BY c.Country, c.City')))
    return 0;
  while ($city = mysql_fetch_assoc($result)) {
    $cities[] = $city;
  }
  return $cities;
}

function	get_ticket_types() {
  if (!($result = mysql_query('SELECT * FROM tickets_types')))
    return 0;
  while ($city = mysql_fetch_assoc($result)) {
    $cities[] = $city;
  }
  return $cities;
}

$cities = get_available_cities();

$ticket_types = get_ticket_types();

$tickets = get_tickets($_SESSION['login']);

function	check_form_edit($values) {
  if (!isset($values['edit_ticket']))
    return false;
  if (empty($values['city'])
      || empty($values['type'])
      || empty($values['quantity'])) {
    echo '<div class="alert">At least one field is missing.</div>';
    return false;
  }
  $query = 'UPDATE tickets SET '
    .'city='.intval($values['city']).', '
    .'type='.intval($values['type']).', '
    .'valid='.(isset($values['valid']) ? 'true' : 'false').', '
    .'quantity='.intval($values['quantity']).', '
    .'details='.'"'.protect($values['details']).'", '
    .'price='.floatval($values['price']).', '
    .'shipping='.floatval($values['shipping'])
    .', sold='.(isset($values['sold']) ? 'true' : 'false')
    .' WHERE id='.$values['id'];
  if (!mysql_query($query)) {
    echo '<div class="alert">Error</div>';
    return false;
  }
  echo '<div class="alert alert-success">Your ticket has been successfully updated!</div>';
  return true;
}

function	check_form_delete($values) {
  if (!isset($values['delete_ticket']) ||
      empty($values['id']))
    return false;
  $query = 'DELETE FROM tickets WHERE id='.$values['id'];
  if (!mysql_query($query)) {
    echo '<div class="alert">Error</div>';
    return false;
  }
  echo '<div class="alert alert-success">Your ticket has been successfully deleted!</div>';
  return true;
}

?>

<?php if ($tickets == 0) { ?>
<div class="alert">No ticket found. <a href="submit">Add one?</a></div>
<?php } else { ?>
<table class="table table-striped table-bordered table-hover">
  <tr>
    <th>city</th>
    <th>type</th>
    <th>valid</th>
    <th>user</th>
    <th>quantity</th>
    <th>details</th>
    <th>price</th>
    <th>shipping</th>
    <th>currency</th>
    <th>sold</th>
    <th>picture</th>
    <th>edit</th>
    <th>delete</th>
  </tr>
  <?php foreach($tickets as $ticket) { ?>
  <tr>
    <td>
      <a href="details?city=<?= $ticket['city'] ?>">
	<?= $ticket['Country'] ?>, <?= $ticket['city_name'] ?></a></td>
    <td><?= $ticket['type_name'] ?> (<?= $ticket['type_details'] ?>)</td>
    <td><?= $ticket['valid'] ? 'Yes' : 'No' ?></td>
    <td><?= $ticket['user'] ?></td>
    <td><?= $ticket['quantity'] ?></td>
    <td><?= $ticket['details'] ?></td>
    <td><?= $ticket['price'] ?></td>
    <td><?= $ticket['shipping'] ?></td>
    <td><?= $ticket['currency'] ?></td>
    <td><?= $ticket['sold'] ? 'Yes' : 'No' ?></td>
    <td>
      <?php if (empty($ticket['picture'])) { ?>
      No
      <?php } else { ?>
      <a href="<?= $ticket['picture'] ?>" target="_blank">
	<img src="<?= $ticket['picture'] ?>" alt="ticket picture">
      </a>
      <?php } ?>
    </td>
    <td>
      <a href="#">
	<button class="btn btn-primary edit" id="<?= $ticket['id'] ?>">Edit</button>
      </a>
    </td>
    <td>
      <form method="post">
	<input type="hidden" name="id" value="<?= $ticket['id'] ?>">
	<input type="submit" name="delete_ticket" value="Delete">
      </form>
    </td>
  </tr>
  <tr class="hidden" id="edit_<?= $ticket['id'] ?>">
    <td colspan="12">

      <form method="post" class="form-horizontal">
	<input type="hidden" name="id" value="<?= $ticket['id'] ?>">

	<div class="control-group">
	  <label class="control-label" for="inputCity">
	    City</label>
	  <div class="controls">
	    <select name="city">
	      <?php foreach ($cities as $city) { ?>
	      <option value="<?= $city['id'] ?>"
		      <?php if ($city['id'] == $ticket['city']) { ?> selected<?php } ?>>
		<?= $city['Country'] ?>, <?= utf8_encode($city['AccentCity']) ?>
	      </option>
	      <?php } ?>
	    </select>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="inputType">
	    Type</label>
	  <div class="controls">
	    <select name="type">
	      <?php foreach ($ticket_types as $ticket_type) { ?>
	      <option value="<?= $ticket_type['id'] ?>"
		      <?php if ($ticket_type['id'] == $ticket['type']) { ?> selected<?php } ?>>
		<?= $ticket_type['name'] ?> (<?= utf8_encode($ticket_type['details']) ?>)
	      </option>
	      <?php } ?>
	    </select>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="inputValid">
	    Valid</label>
	  <div class="controls">
	    <input name="valid" type="checkbox" id="inputValid"
		   <?php if ($ticket['valid']) { ?> checked<?php } ?>>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="inputQuantity">
	    Quantity</label>
	  <div class="controls">
	    <input name="quantity" type="text" id="inputQuantity" value="<?= $ticket['quantity'] ?>">
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="inputDetails">
	    Details</label>
	  <div class="controls">
	    <textarea name="details" id="inputDetails"></textarea>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="inputPrice">
	    Price</label>
	  <div class="controls">
	    <input name="price" type="text" class="input-mini" id="inputPrice"
		   value="<?= $ticket['price'] ?>">
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="inputShipping">
	    Shipping</label>
	  <div class="controls">
	    <input name="shipping" type="text" class="input-mini" id="inputPrice"
		   value="<?= $ticket['shipping'] ?>">
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="inputSold">
	    Sold</label>
	  <div class="controls">
	    <input name="sold" type="checkbox" id="inputSold"
		   <?php if ($ticket['sold']) { ?> checked<?php } ?>>
	  </div>
	</div>

	<div class="control-group">
	  <div class="controls">
	    <input type="submit" name="edit_ticket" value="Edit ticket" class="btn btn-success">
	  </div>
	</div>

      </form>
    </td>
  </tr>
  <?php } ?>
</table>
<?php } ?>

<form method="post">
  <input type="submit" name="logout" value="logout" class="btn btn-danger">
</form>



