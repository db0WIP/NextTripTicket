<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: API requests for user's reviews on cities                     //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

require_once('nmsp/pager.php');

$get_reviews_default = array('reviews_quantity' => 'all',
			     'reviews_page'     => 0);

function	ws_get_reviews($p) {
  return array();
}
