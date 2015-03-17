<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: API requests for cities                                       //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

require_once('nmsp/pager.php');
require_once('requests/reviews.php');
require_once('requests/tickets.php');

$get_city_required = array('city_id');
$city_defaults = array('with_tickets' => true,
		       'with_reviews' => false);
$get_city_default = array_merge($city_defaults, $get_tickets_default, $get_reviews_default);

function	ws_get_city($p) {
  $c = select_one('SELECT c.*, d.* FROM cities AS c JOIN cities_details AS d WHERE c.id=? AND d.id=c.id',
		  // todo .($p['with_tickets'] === true ? ' AND (SELECT count(*) FROM tickets AS tt WHERE tt.city=d.id)>0' : '')
		  // todo .(''),
		  array($p['city_id']));
  $rsp = array('id' => $c['id'],
	       'name' => $c['City'],
	       'info' => array('accents' => $c['AccentCity'],
			       'country' => $c['Country'],
			       'region' => $c['Region'],
			       'population' => $c['Population'],
			       'latitude' => $c['Latitude'],
			       'longitude' => $c['Longitude']),
	       'pictures' => array($c['picture1'], $c['picture2'], $c['picture3']),
	       'quote' => $c['quote'],
	       'description' => $c['description'],
	       'tickets' => ws_get_tickets($p),
	       'reviews' => ws_get_reviews($p));
  return ($rsp);
}

$get_cities_required = array();
$cities_default = array('cities_quantity' => 'all',
			'cities_page' => 0);
$get_cities_default = array_merge($cities_default, $get_city_default);

function	ws_get_cities($p) {
  $cities_sql = select('SELECT id FROM cities_details '.\Pager\limit($p, 'cities'));
  $cities = array();
  foreach ($cities_sql as $city) {
    $p['city_id'] = $city['id'];
    $cities[] = ws_get_city($p);
  }
  return \Pager\rsp($p, $cities, 'cities', 'cities_details');
}
