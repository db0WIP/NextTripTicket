<?php
require_once('../conf.php');

mysql_connect($mysql_host, $mysql_login, $mysql_password);
mysql_select_db('NextTripTicket');

function	selectall($table, $limit = 10) {
  if (!$result = mysql_query('SELECT * FROM '.$table.' LIMIT '.$limit))
    return false;
  $idx = 0;
  while (@$result_array['flags'][$idx] = mysql_field_flags($result, $idx))
    $idx++;
  while ($row = mysql_fetch_assoc($result)) {
    $result_array[] = $row;
  }
  return $result_array;
}

function	total($table) {
  if (!($result = mysql_query('SELECT count(*) AS nb FROM '.$table)))
    return 0;
  $row = mysql_fetch_assoc($result);
  return $row['nb'];
}

function	show_result($result) {
  if (!$result) {
    echo '<div class="alert">'.mysql_error().'</div>';
    return ;
  }
  if (empty($result)) {
    echo '<div class="alert alert-info">Empty table</div>';
    return ;
  }
  echo '<table class="table table-striped table-bordered table-hover">';
  echo '<tr>';
  $idx = 0;
  foreach ($result[0] as $key => $_) {
    echo '<th id="'.$key.'">'.$key.'<br><small>'.$result['flags'][$idx]
      .'</small></th>';
    $idx++;
  }
  echo '</tr>';
  foreach ($result as $k => $row) {
    if ($k === 'flags')
      continue;
    echo '<tr>';
    foreach ($row as $key => $value) {
      echo '<td headers="'.$key.'">';
      $value = utf8_encode($value);
      if (strncmp($value, 'http', 4) == 0)
	echo '<a href="'.$value.'" target="_blank">Click to go to the URL</a>';
      else
	echo $value;
      echo '</td>';
    }
    echo '</tr>';
  }
  echo '</table>';
}

?>
<?php
$result = selectall('cities');
$total = total('cities');
?>
<div><div class="well">
  <h3 id="cities">Cities</h3>
  <p>
    This table contain all the cities in the world.
    Source: <a href="http://www.maxmind.com/en/worldcities" target="_blank">MaxMind</a>.<br>
    This table contains <?= $total ?> cities, so we only display the first 10.
  </p>
</div></div>
<?php show_result($result);
?>
<div><div class="well">
  <h3>Cities Details</h3>
  <p>
    This table is filled by the users that submit tickets.
    It contains more information about the city.
  </p>
</div></div>
<?php
$result = selectall('cities_details');
show_result($result);
?>

<?php
$result = selectall('users');
?>
<div><div class="well">
  <h3 id="users">Users</h3>
  <p>
    Table of users to log in their accounts and manage their tickets.
    The password is crypted using MD5.
  </p>
</div></div>
<?php show_result($result); ?>

<?php
$result = selectall('reviews');
?>
<div><div class="well">
  <h3>Reviews</h3>
  <p>
    The users can submit reviews of the cities.
  </p>
</div></div>
<?php show_result($result); ?>

<?php
$result = selectall('tickets_types');
?>
<div><div class="well">
  <h3>Tickets_Types</h3>
  <p>
    This table contains the list of available types of tickets.
  </p>
</div></div>
<?php show_result($result); ?>

<?php
$result = selectall('currencies');
?>
<div><div class="well">
  <h3>Currencies</h3>
  <p>
    This table contains the list of available currencies.
  </p>
</div></div>
<?php show_result($result); ?>

<?php
$result = selectall('tickets');
?>
<div><div class="well">
  <h3 id="tickets">Tickets</h3>
  <p>
    All the tickets that have been submitted by users on the website.
  </p>
</div></div>
<?php show_result($result); ?>
