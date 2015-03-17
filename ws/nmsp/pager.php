<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: Tools to calculate pages for large amount of data             //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

namespace Pager;

function	limit($p, $data) {
  if ($p[$data.'_quantity'] === 'all'
      || $p[$data.'_quantity'] < 0
      || $p[$data.'_page'] < 0) // todo: return an error
    return '';
  $quantity = intval($p[$data.'_quantity']);
  $page     = intval($p[$data.'_page']);
  return (' LIMIT '.($quantity * $page)
	  .', '.$quantity);
  }

function	rsp($p, $rsp, $tab, $to_count = 0) {
  if (!$to_count)
    $to_count = $tab;
  $total = select_count($tab);
  if ($p[$tab.'_quantity'] === 'all'
      || !($p[$tab.'_quantity']))
    $count = 1;
  else
    $count = ceil($total / $p[$tab.'_quantity']);
  return array('total_pages' => $count,
	       'total' => $total,
	       'page_number' => intval($p[$tab.'_page']),
	       'page_quantity' => ($p[$tab.'_quantity'] === 'all'
				   ? 1 : intval($p[$tab.'_quantity'])),
	       'page' => $rsp);
}
