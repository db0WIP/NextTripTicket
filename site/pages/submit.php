<?php
require_once('../conf.php');

mysql_connect($mysql_host, $mysql_login, $mysql_password);
mysql_select_db('NextTripTicket');

function protect($string) {
  return (htmlspecialchars(stripslashes($string)));
}

$r = include_once('login.php');
if (!$r)
  return;

function	upload_picture() {
  if (empty($_FILES))
    return true;
  // Configuration - Your Options
  $allowed_filetypes = array('.jpg','.gif','.bmp','.png'); // These will be the types of file that will pass the validation.
  $max_filesize = 209715200; // Maximum filesize in BYTES
  $upload_path = 'img/tickets/'; // The place the files will be uploaded to (currently a 'files' directory).
 
  $filename = $_FILES['picture']['name']; // Get the name of the file (including file extension).
  $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
 
  // Check if the filetype is allowed, if not DIE and inform the user.
  if(!in_array($ext,$allowed_filetypes))
    return display_alert('The file you attempted to upload is not allowed.');
 
  // Now check the filesize, if it is too large then DISPLAY_ALERT and inform the user.
  if(filesize($_FILES['picture']['tmp_name']) > $max_filesize)
    return display_alert('The file you attempted to upload is too large.');
  
  // Check if we can upload to the specified path, if not DISPLAY_ALERT and inform the user.
  if(!is_writable($upload_path))
    return display_alert('You cannot upload to the specified directory, please CHMOD it to 777.');
  
  // Upload the file to your specified path.
  if(!move_uploaded_file($_FILES['picture']['tmp_name'],$upload_path . $filename))
    return display_alert('There was an error during the file upload.  Please try again.'); // It failed :(.
  return $upload_path.$filename;
}

function	check_form($values) {
  if (!isset($values['submit_new_ticket']))
    return false;
  if (empty($values['city'])
      || empty($values['ticket_type'])
      || empty($values['quantity'])) {
    echo '<div class="alert">At least one field is missing.</div>';
    return false;
  }
  if (!($pic = upload_picture()))
    return false;
  $query = 'INSERT INTO tickets(city, type, valid, user, quantity, details, price, shipping, currency, sold, picture) VALUES('
    .intval($values['city']).', '
    .intval($values['ticket_type']).', '
    .intval($values['valid']).', '
    .'"'.$_SESSION['login'].'", '
    .intval($values['quantity']).', '
    .'"'.protect($values['details']).'", '
    .floatval($values['price']).', '
    .floatval($values['shipping'])
    .', 2, 0, '
    .'"'.(is_string($pic) ? $pic : '').'"'
    .')';
  if (!mysql_query($query)) {
    echo '<div class="alert">Error</div>';
    return false;
  }
  echo '<div class="alert alert-success">Your ticket has been successfully added!<br><br>Add another one?</div>';
  return true;
}

check_form($_POST);

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

?>

<div id="submit">
  <?php if ($cities === 0) { ?>
  <div class="alert alert-error">
    No city found.
  </div>
  <?php } else { ?>

  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="209715200" />

    <fieldset id="theCity">
      <h2>The City</h2>

      <div class="alert alert-info">
	If the city you are looking for is not in the list,
	you should add details to this city using <a href="/display">this page</a>.
      </div>

      <select name="city">
	<?php foreach ($cities as $city) { ?>
	<option value="<?= $city['id'] ?>">
	  <?= $city['Country'] ?>, <?= utf8_encode($city['AccentCity']) ?>
	</option>
	<?php } ?>
      </select>
      <br>

      <input type="submit" id="toCity" value="Next »" class="btn btn-success navigate">
    </fieldset> <!-- theCity -->

    <fieldset id="theTicket" class="hidden">
      <h2>The Ticket</h2>

      <select name="ticket_type">
	<?php foreach ($ticket_types as $ticket) { ?>
	<option value="<?= $ticket['id'] ?>">
	  <?= $ticket['name'] ?> (<?= utf8_encode($ticket['details']) ?>)
	</option>
	<?php } ?>
      </select><br>

      Shipping price
      <div class="input-append">
	<input type="text" class="input-mini" value="0.60" name="shipping">
	<span class="add-on">dollars</span>
      </div>
      <br>
      
      <a href="#" id="more_link"><button class="btn">More...</button></a><br>

      <div id="more" class="hidden">
	Picture of ticket <input type="file" name="picture"><br>
	Price
	<div class="input-append">
	  <input type="text" class="input-mini" value="0" name="price">
	  <span class="add-on">dollars</span>
	</div><br>
	<input name="valid" type="checkbox" value="1" checked> This ticket is valid<br>
	Quantity <input name="quantity" class="input-mini" type="text" value="1"><br>
	Details	<textarea name="details"></textarea><br>
      </div>

      <input type="submit" id="toTicket" value="« Previous" class="btn btn-success navigate">
      <input type="submit" name="submit_new_ticket" value="Submit new ticket" class="btn btn-primary">
    </fieldset> <!-- theTicket -->

  </form>
  <? } ?>

</div> <!-- submit -->
<?php

