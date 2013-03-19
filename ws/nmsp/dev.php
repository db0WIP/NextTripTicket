<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: Developers tools                                              //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

namespace Dev;

require_once('includes/conf.php');

function	debug($data) {
  global $dev;
  if ($dev === true) {
    print_r($data);
    echo "\n";
  }
}

