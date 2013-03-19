<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: Tools to calculate pages for large amount of data             //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

namespace Pager;

function	limit($p, $data) {
  if ($p[$data.'_quantity'] === 'all')
    return '';
  $quantity = intval($p[$data.'_quantity']);
  $page     = intval($p[$data.'_page']);
  return (' LIMIT '.($quantity * $page)
	  .', '.$quantity);
  }

function	rsp($p, $rsp, $tab, $to_count = 0) {
  if (!$to_count)
    $to_count = $tab;
  if ($p[$tab.'_quantity'] === 'all' || !($p[$tab.'_quantity']))
    $count = 1;
  else
    $count = ceil(select_count($tab) / $p[$tab.'_quantity']);
  return array('total_pages' => $count,
	       'page_number' => $p[$tab.'_page'],
	       'page_quantity' => $p[$tab.'_quantity'],
	       'page' => $rsp);
}
