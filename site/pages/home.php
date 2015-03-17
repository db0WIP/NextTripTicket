<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: Home page, display latest tickets                             //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

function	display_tickets($tickets) {
?>
<div class="row-fluid">
<?php
foreach ($tickets as $ticket) {
   if (empty($ticket['img']))
     $ticket['img'] = 'blank_ticket.png';
   if (empty($ticket['content']))
     $ticket['content'] = $ticket['city'].', '.$ticket['country'];
    ?>
  <div class="span4">
    <a href="<?= $ticket['url'] ?>">
      <div class="ticket">
	<div class="content_wrap">
	  <div class="content">
	    <?= $ticket['content'] ?>
	  </div> <!-- content -->
	</div> <!-- content wrap -->
	<img src="img/tickets/<?= $ticket['img'] ?>"
             alt="Ticket <?= $ticket['city'] ?>">
      </div> <!-- ticket -->
    </a>
  </div> <!-- .span -->
<?php
    }
?>
</div> <!-- row-fluid -->
<?php
}

display_tickets(array(
		      // array('content' => 'Random ticket',
		      // 	    'url' => 'random'),
		      // array('content' => 'Search',
		      // 	    'url' => 'search'),
		      array('content' => 'Submit your own ticket',
			    'url' => 'submit'),
		      array('content' => 'My account',
			    'url' => 'account'),
		      array('content' => 'Contact',
			    'url' => 'contact'),
		      ));

include_once('pages/slideshow.php');

