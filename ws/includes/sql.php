<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: MySQL Database initialization and functions                   //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

require_once('../conf.php');

$db = new PDO('mysql:host='.$mysql_host.';dbname='.$mysql_dbname,
	      $mysql_login, $mysql_password);

$db->setAttribute(PDO::ATTR_ERRMODE,
		  ($dev ? PDO::ERRMODE_WARNING
		   : PDO::ERRMODE_SILENT));

function	select($query, $data = array()) {
  global $db;
  $q = $db->prepare($query);
  $q->execute($data);
  return $q->fetchAll();
}

function	select_one($query, $data = array()) {
  $rsp = select($query, $data);
  return $rsp[0];
}

function	select_count($tab) {
  $rsp = select_one('SELECT count(*) AS nb FROM '.$tab);
  return $rsp['nb'];
}


