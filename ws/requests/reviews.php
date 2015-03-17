<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: API requests for user's reviews on cities                     //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

require_once('nmsp/pager.php');

$get_reviews_required = array('city_id');
$get_reviews_default = array('reviews_quantity' => 'all',
			     'reviews_page'     => 0);

function	ws_get_reviews($p) {
  $reviews_sql = select('SELECT * FROM reviews WHERE id_city=? '
			.\Pager\limit($p, 'reviews'),
			array($p['city_id']));
  $reviews = array();
  foreach ($reviews_sql as $review) {
    $reviews[] = array('id' => $review['id'],
		       'type' => $review['type'],
		       'valid' => $review['valid'],
		       'user' => $review['user'],
		       'quantity' => $review['quantity'],
		       'price' => $review['price'],
		       'price_shipping' => $review['shipping'],
		       'details' => $review['details']);
  }
  return \Pager\rsp($p, $reviews, 'reviews');
  return array();
}
