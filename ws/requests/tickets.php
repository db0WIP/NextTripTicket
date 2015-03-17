<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: API requests for tickets submitted by users                   //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

require_once('nmsp/pager.php');

$get_tickets_default = array('tickets_quantity' => 'all',
			     'tickets_page'     => 0,
			     'city_id'          => 'all');

function	ws_get_tickets($p) {
  global $website_url;
  $tickets_sql = select('SELECT t.*, tt.name AS type_name, tt.details AS type_details'
			.' FROM tickets AS t'
			.' JOIN tickets_types AS tt WHERE t.type=tt.id'
			.($p['city_id'] === 'all' ? '' : ' AND t.city=? ')
			.\Pager\limit($p, 'tickets'),
			array($p['city_id'])); // try specify string city
  $tickets = array();
  foreach ($tickets_sql as $ticket) {
    $tickets[] = array('id' => intval($ticket['id']),
		       'city_id' => intval($ticket['city']),
		       'url' => $website_url.'tickets/'.$ticket['id'],
		       'type' => array('id' => intval($ticket['type']),
				       'name' => $ticket['type_name'],
				       'details' => $ticket['type_details']),
		       'valid' => (bool)($ticket['valid']),
		       'user' => $ticket['user'],
		       'quantity' => intval($ticket['quantity']),
		       'price' => floatval($ticket['price']),
		       'price_shipping' => floatval($ticket['shipping']),
		       'details' => $ticket['details']);
  }
  return \Pager\rsp($p, $tickets, 'tickets');
}
