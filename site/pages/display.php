<?php

require_once('../conf.php');

mysql_connect($mysql_host, $mysql_login, $mysql_password);
mysql_select_db('NextTripTicket');

function	selectpage($table, $page_number = 1, $quantity = 3) {
  $page = $page - 1;
  if ($quantity === 'all'
      || $quantity < 0
      || $page_number < 0)
    return $limit = '';
  $limit = (' LIMIT '.($quantity * $page_number).', '.$quantity);
  if (!$result = mysql_query('SELECT * FROM '.$table.' ORDER BY Population DESC'.$limit))
    return false;
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

function	display_cities($citys) {
?>
<div class="row-fluid">
<?php
foreach ($citys as $city) {
   if (empty($city['img']))
     $city['img'] = 'blank_ticket.png';
   if (empty($city['content']))
     $city['content'] = $city['city'].', '.$city['country'];
    ?>
  <div class="span4">
    <a href="#">
      <div class="ticket">
	<div class="content_wrap">
	  <div class="content">
	    <?= utf8_encode($city['AccentCity']) ?>
	  </div>
	</div>
	<img src="img/tickets/<?= $city['img'] ?>"
             alt="City <?= $city['city'] ?>">
      </div>
    </a>
    <dl class="well dl-horizontal">
      <dt>Country</dt><dd><?= $city['Country'] ?></dd>
      <dt>Region</dt><dd><?= $city['Region'] ?></dd>
      <dt>Population</dt><dd><?= $city['Population'] ?></dd>
      <dt>Latitude</dt><dd><?= $city['Latitude'] ?></dd>
      <dt>Longitude</dt><dd><?= $city['Longitude'] ?></dd>
    </dl>
    <a href="/details?city=<?= $city['id'] ?>">
      <button class="btn"><i class="icon-pencil"></i> Add/See details</button>
    </a><br><br><br>
  </div>
<?php
  }
}

$perpage = 3;
$total = total('cities');
$totalpage = ceil($total / $perpage) - 1;

$page = 1;
if (isset($_GET['page']))
  $page = intval($_GET['page']);
if ($page <= 0)
  $page = 1;
if ($page > $totalpage)
  $page = $totalpage;

display_cities(selectpage('cities', $page, $perpage));
?>

<div class="pagination pagination-large">
  <ul>
    <?php if ($page != 1) { ?>
    <li><a href="/display?page=1">First</a></li>
    <?php } ?>
    <?php if ($page > 1) { ?>
    <li><a href="/display?page=<?= $page - 1 ?>">Prev</a></li>
    <?php } ?>
    <?php if ($page - 3 > 0) { ?>
    <li><a href="/display?page=<?= $page - 3 ?> "><?= $page - 3 ?></a></li>
    <?php } ?>
    <?php if ($page - 2 > 0) { ?>
    <li><a href="/display?page=<?= $page - 2 ?> "><?= $page - 2 ?></a></li>
    <?php } ?>
    <?php if ($page - 1 > 0) { ?>
    <li><a href="/display?page=<?= $page - 1 ?> "><?= $page - 1 ?></a></li>
    <?php } ?>
    <li><a href="/display?page=<?= $page ?>"><b><?= $page ?></b></a></li>
    <?php if ($page + 1 < $totalpage) { ?>
    <li><a href="/display?page=<?= $page + 1 ?> "><?= $page + 1 ?></a></li>
    <?php } ?>
    <?php if ($page + 2 < $totalpage) { ?>
    <li><a href="/display?page=<?= $page + 2 ?> "><?= $page + 2 ?></a></li>
    <?php } ?>
    <?php if ($page + 3 < $totalpage) { ?>
    <li><a href="/display?page=<?= $page + 3 ?> "><?= $page + 3 ?></a></li>
    <?php } ?>
    <?php if ($page < $totalpage) { ?>
    <li><a href="/display?page=<?= $page + 1 ?>">Next</a></li>
    <?php } ?>
    <?php if ($page != $totalpage) { ?>
    <li><a href="/display?page=<?= $totalpage?>">Last</a></li>
    <?php } ?>
  </ul>
</div>
