<?php

require_once('../conf.php');

mysql_connect($mysql_host, $mysql_login, $mysql_password);
mysql_select_db('NextTripTicket');

$r = mysql_query('SELECT t.*, c.Country, c.AccentCity FROM tickets AS t JOIN cities AS c WHERE c.id=t.city ORDER BY t.user, t.city, t.valid, t.quantity, t.type, t.price');
while ($ticket = mysql_fetch_assoc($r))
  $tickets[] = $ticket;

function	display_alert($msg, $success = false) {
  ?><div class="alert alert-<?php if ($success) echo 'success'; else echo 'error'; ?>"><?= $msg ?></div><?php
    return false;
}

function	create_account($login, $password, $email) {
  $q = 'INSERT INTO users(login, email, password) VALUES('
    .'\''.mysql_real_escape_string($login).'\', '
    .'\''.mysql_real_escape_string($email).'\', '
    .'\''.md5($password).'\')';
  $r = mysql_query($q);

  if ($r)
    display_alert('Your account has been successfully created.', true);
  else
    display_alert('Your account has not been created.');
}

function	check_account($login, $password) {
  $r = mysql_query('SELECT * FROM users WHERE '
		   .'login=\''.mysql_real_escape_string($login).'\''
		   .'AND password=\''.md5($password).'\''
		   );
  return $r;
}

function	valid_form($p) {
  if (empty($p['name'])
      || empty($p['password'])
      || empty($p['email'])
      || empty($p['ticket'])
      || empty($p['content']))
    return display_alert('At least one of the fields is empty.');
  $q = 'SELECT login FROM users WHERE login=\''.mysql_real_escape_string($p['name']).'\'';
  $r = mysql_query($q);
  if (!$r)
    create_account($p['name'], $p['password'], $p['email']);
  else
    if (!check_account($p['name'], $p['password']))
      return display_alert('The password is incorrect for this account.');
  $message = "Hello,\n\n
Someone sent you an email on NextTripTicket.\n\n
About ticket number ".$p['ticket']."\n
Login: ".$p['name']."\n
Email: ".$p['email']."\n
Content: ".$p['content']."\n\n
So you should answer now.
";
  $r = mail('db0company@gmail.com', 'New email from contact form', $message);
  if (!$r)
    display_alert('The message has not been sent.');
  else
    display_alert('The message has been sent.', true);
}
?>

<div class="row-fluid">
  <div class="span5">
    <img src="img/interface/contact.png">
  </div>
  <div class="span7">
    <?php
  
if (isset($_POST['contact']))
   valid_form($_POST);

?>
    <form method="post" class="form-horizontal">
      <div class="control-group">
	<label class="control-label white" for="inputName"><i class="icon-white icon-user"></i> Name</label>
	<div class="controls">
	  <input name="name" type="text" id="inputName" placeholder="Richard Carlson">
	</div>
      </div>
      <div class="control-group">
	<label class="control-label white" for="inputPassword"><i class="icon-white icon-user"></i> Password
	  <a href="#" class="atooltip" data-toggle="tooltip" data-original-title="The password of your account (if you have one) or a new password to create your account" data-placement="right">
	    <i class="icon-white icon-question-sign"></i></a>
	</label>
	<div class="controls">
	  <input name="password" type="password" id="inputPassword" placeholder="******">
	</div>
      </div>
      <div class="control-group">
	<label class="control-label white" for="inputEmail"><i class="icon-white icon-envelope"></i> Email</label>
	<div class="controls">
	  <input name="email" type="text" id="inputEmail" placeholder="richard@carlson.com">
	</div>
      </div>
      <div class="control-group">
	<label class="control-label white" for="inputTicket"><i class="icon-white icon-tags"></i> About ticket</label>
	<div class="controls">
	  <select name="ticket">
	    <?php foreach ($tickets as $ticket) { ?>
	    <option value="<?= $ticket['id'] ?>"><?= utf8_encode($ticket['AccentCity']) ?> (<?= $ticket['Country'] ?>) by <?= $ticket['user'] ?></option>
	    <?php } ?>
	  </select>
	</div>
      </div>
      <div class="control-group">
	<label class="control-label white" for="inputContent"><i class="icon-white icon-pencil"></i> Content</label>
	<div class="controls">
	  <textarea rows="10" name="content"></textarea>
	</div>
      </div>
      <div class="control-group">
	<div class="controls">
	  <input type="submit" class="btn btn-info" value="Contact" name="contact">
	</div>
      </div>
    </form>
  </div>
</div>



