<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: Misc functions and values                                     //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

$name = 'NextTripTicket.com';
$slogan = 'A new adventure start for travel lovers!';

function	random_wallper() {
  $dir = 'img/wallpapers/';
  if (!$handle = opendir($dir))
    return false;
  while ($file = readdir($handle))
    if ($file[0] != '.')
      $wallpapers[] = $file;
  closedir($handle);
  shuffle($wallpapers);
  return $dir.$wallpapers[0];
}
