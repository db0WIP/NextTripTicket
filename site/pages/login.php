<?php

function	display_alert($msg, $success = false) {
  ?><div class="alert alert-<?php if ($success) echo 'success'; else echo 'error'; ?>"><?= $msg ?></div><?php
    return $success;
}

function	create_account($login, $password, $email) {
  $q = 'INSERT INTO users(login, email, password) VALUES('
    .'\''.mysql_real_escape_string($login).'\', '
    .'\''.mysql_real_escape_string($email).'\', '
    .'\''.md5($password).'\')';
  $r = mysql_query($q);

  if ($r)
    return display_alert('Your account has been successfully created.', true);
  else
    return display_alert('Your account has not been created.');
}

function	check_account($login, $password) {
  $q = 'SELECT * FROM users WHERE '
    .'login=\''.mysql_real_escape_string($login).'\' '
    .'AND password=\''.md5($password).'\'';
  $r = mysql_query($q);
  $r = mysql_fetch_assoc($r);
  return $r;
}

function	valid_form_login($p) {
  if (!isset($p['submitlogin']))
    return false;
  if (empty($p['name'])
      || empty($p['password'])
      || empty($p['email']))
    return display_alert('At least one of the fields is empty.');
  $q = 'SELECT login FROM users WHERE login=\''.mysql_real_escape_string($p['name']).'\'';
  $r = mysql_query($q);
  $r = mysql_fetch_assoc($r);
  if (!$r) {
    if (!create_account($p['name'], $p['password'], $p['email'])) {
      return display_alert("Error occured");
    }
  }
  else {
    if (!check_account($p['name'], $p['password'])) {
      return display_alert('The password is incorrect for this account.');
    }
  }
  display_alert('You successfully logged in.', true);
  $_SESSION['login'] = $p['name'];
  return true;
}

function	show_login_form() {
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
	  <input name="email" type="email" id="inputEmail" placeholder="richard@carlson.com">
	</div>
      </div>
      <div class="control-group">
	<div class="controls">
	  <input type="submit" class="btn btn-info" value="Login/Create Account" name="submitlogin">
	</div>
      </div>
    </form>
<?php
}

if (isset($_POST['logout'])) {
  unset($_SESSION['login']);
 }

valid_form_login($_POST);
if (!isset($_SESSION['login'])) {
  show_login_form();
  return false;
 }

return true;
