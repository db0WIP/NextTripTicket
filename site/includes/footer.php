<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: HTML Footer                                                   //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //
?>
      </div>

      <footer>
	<nav>
          <a href="contact">Contact</a> - 
	  <a href="account">My account</a> - 
	  <a href="about">About</a> - 
	  <a href="faq">F.A.Q.</a> - 
	  <a href="partners">Partners</a> - 
	  <a href="dev">Resources/Developers</a> - 
	  <a href="https://github.com/db0company/NextTripTicket" target="_blank">Source Code</a>
	</nav>
      </footer>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.cycle.all.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/api.js"></script>
    <script src="js/jquery.jsonp.js" type="text/javascript"></script>
    <script src="js/preset.js"></script>
<?php if (file_exists('js/'.$p.'.js')) { ?>
    <script src="js/<?= $p ?>.js"></script>
<?php } ?>

  </body>
</html>
