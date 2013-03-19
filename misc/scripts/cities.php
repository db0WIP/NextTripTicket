<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: Script to insert cities in the database                       //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

require_once('../../ws/includes/sql.php');

// download it from: http://www.maxmind.com/en/worldcities
$citiesfile = 'worldcitiespop.txt';

if (($handle = fopen($citiesfile, 'r'))) {
  $table = fgetcsv($handle, 1000);
  while (($data = fgetcsv($handle, 1000))) {
    $req = $db->prepare('INSERT INTO cities ('.(implode($table, ', ')).') VALUES (?, ?, ?, ?, ?, ?, ?)');
    $req->execute($data);
  }
  fclose($handle);
 }
