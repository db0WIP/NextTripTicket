<?php

require_once('../conf.php');

mysql_connect($mysql_host, $mysql_login, $mysql_password);
mysql_select_db('NextTripTicket');

$id = intval($_GET['city']);

$city = mysql_query('SELECT * FROM cities WHERE id='.intval($id));
$city = mysql_fetch_assoc($city);
$city_details = mysql_query('SELECT * FROM cities_details WHERE id='.intval($id));
$city_details = mysql_fetch_assoc($city_details);
if (!$city) {
   echo '<div class="alert">This city does not exists.</div>';
}
elseif ($city_details) {
?>
<div class="row-fluid">
  <div class="span5">
    <?php showinfo($city); ?>
  </div>
  <div class="span7">
    <dl class="well dl-horizontal">
      <dt>Description</dt>
      <dd>
	<p class="well">
	  <?= utf8_encode($city_details['description']) ?>
	</p>
      </dd>
      <dt>Quote</dt>
      <dd>
	<blockquote>
	  <?= utf8_encode($city_details['quote']) ?>
	</blockquote>
      </dd>
    </dl>
    <ul class="thumbnails">
      <li class="span4">
	<a href="<?= $city_details['picture1'] ?>" target="_blank"
	   class="thumbnail">
	  <img src="<?= $city_details['picture1'] ?>" alt="picture1">
	</a>
      </li>
      <li class="span4">
	<a href="<?= $city_details['picture2'] ?>" target="_blank"
	   class="thumbnail">
	  <img src="<?= $city_details['picture2'] ?>" alt="picture2">
	</a>
      </li>
      <li class="span4">
	<a href="<?= $city_details['picture3'] ?>" target="_blank"
	   class="thumbnail">
	  <img src="<?= $city_details['picture3'] ?>" alt="picture3">
	</a>
      </li>

  </div>
<?php
}
else {
   if (!validform($id))
     showform($city);
}

function	validform($id) {
  if (!isset($_POST['add']))
    return false;
  if (empty($_POST['description'])
      || empty($_POST['quote'])
      || empty($_POST['picture1'])
      || empty($_POST['picture2'])
      || empty($_POST['picture3'])) {
    echo '<div class="alert">One of the field was empty.</div>';
    return false;
  }
  $query = 'INSERT INTO cities_details(id, description, quote, picture1, picture2, picture3) VALUES('.$id.', \''.$_POST['description'].'\', \''.$_POST['quote'].'\', \''.$_POST['picture1'].'\', \''.$_POST['picture2'].'\', \''.$_POST['picture3'].'\')';
  if (!$city = mysql_query($query)) {
    echo '<div class="alert">Error</div>';
    return false;
  }
  echo '<div class="alert alert-success">The details has been added. Thank you!</div>';
  return true;
}

function	showinfo($city) {
?>
    <div class="well">
      <h1><?= utf8_encode($city['AccentCity']) ?></h1>
    </div>
    <dl class="well dl-horizontal">
      <dt>Country</dt> <dd><?= $city['Country'] ?></dd>
      <dt>Region</dt><dd><?= $city['Region'] ?></dd>
      <dt>Population</dt><dd><?= $city['Population'] ?></dd>
      <dt>Latitude</dt><dd><?= $city['Latitude'] ?></dd>
      <dt>Longitude</dt><dd><?= $city['Longitude'] ?></dd>
    </dl>
<?
}

function	showform($city) {
?>
<div class="row-fluid">
  <div class="span5">
    <?php showinfo($city); ?>
  </div>
  <div class="span7">
    <form method="post" class="form-horizontal well">
      <div class="control-group">
	<label class="control-label" for="inputDescription">Description</label>
	<div class="controls">
	  <input name="description" type="text" id="inputDescription" placeholder="Description">
	</div>
      </div>
      <div class="control-group">
	<label class="control-label" for="inputQuote">Quote</label>
	<div class="controls">
	  <input name="quote" type="text" id="inputQuote" placeholder="Quote">
	</div>
      </div>
      <div class="control-group">
	<label class="control-label" for="inputPicture1">Picture1</label>
	<div class="controls">
	  <input name="picture1" type="text" id="inputPicture1" placeholder="URL of a picture">
	</div>
      </div>
      <div class="control-group">
	<label class="control-label" for="inputPicture2">Picture2</label>
	<div class="controls">
	  <input name="picture2" type="text" id="inputPicture2" placeholder="URL of a picture">
	</div>
      </div>
      <div class="control-group">
	<label class="control-label" for="inputPicture3">Picture3</label>
	<div class="controls">
	  <input name="picture3" type="text" id="inputPicture3" placeholder="URL of a picture">
	</div>
      </div>
      <div class="control-group">
	<div class="controls">
	  <input type="submit" class="btn btn-info" value="Add details" name="add">
	</div>
      </div>
    </form>
  </div>
</div>
<?php
}

?>
