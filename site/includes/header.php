<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: HTML Header                                                   //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?= $name ?> :: <?= $slogan ?></title>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if ($dev) { ?>
    <link href="css/style.less" rel="stylesheet/less" type="text/css" />
    <script src="https://raw.github.com/cloudhead/less.js/master/dist/less-1.3.3.min.js" type="text/javascript"></script>
<?php } else { ?>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
<? } ?>
    <script>
      var api_url = '<?= $api_url ?>';
    </script>
  </head>
  <body<?php
   if ($wallpaper = random_wallper())
     echo ' style="background-image: url(\'', $wallpaper, '\');"';
?>>
    <div id="main">
      <header>
	<img src="img/interface/nextTripTicket_color.png" alt="nextTripTicket.com">
      </header>
      <div id="content">
