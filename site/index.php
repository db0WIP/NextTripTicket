<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: Index page, display layout and check pages                    //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

session_start();

require_once('../conf.php');
require_once('includes/tools.php');
require_once('includes/header.php');

$p = 'home';
if (!empty($_GET['p']))
  $p = $_GET['p'];
if (!file_exists('pages/'.$p.'.php'))
  $p = 'error';
require_once('pages/'.$p.'.php');

require_once('includes/footer.php');
