<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: API requests for tickets submitted by users                   //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

require_once('nmsp/pager.php');

$get_tickets_required = array('city_id');
$get_tickets_default = array('tickets_quantity' => 'all',
			     'tickets_page'     => 0);

function	ws_get_tickets($p) {
  $tickets_sql = select('SELECT * FROM tickets WHERE city=? '.\Pager\limit($p, 'tickets'),
			array($p['city_id']));
  $tickets = array();
  foreach ($tickets_sql as $ticket) {
    $tickets[] = array('id' => $ticket['id'],
		       'type' => $ticket['type'],
		       'valid' => $ticket['valid'],
		       'user' => $ticket['user'],
		       'quantity' => $ticket['quantity'],
		       'price' => $ticket['price'],
		       'price_shipping' => $ticket['shipping'],
		       'details' => $ticket['details']);
  }
  return \Pager\rsp($p, $tickets, 'tickets');
}
