<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: API requests for tickets_types submitted by users             //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

require_once('nmsp/pager.php');

$get_tickets_types_default = array('tickets_types_quantity' => 'all',
			       'tickets_types_page'     => 0,
			       'city_id'          => 'all');

function	ws_get_tickets_types($p) {
}