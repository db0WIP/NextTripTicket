<?php
// ************************************************************************** //
// Project: NextTripTicket, A new adventure start for travel lovers!          //
// Description: API General Namespace (url, params check, encode, ...)        //
// Author: db0 (db0company@gmail.com, http://db0.fr/)                         //
// Latest version, copyright: https://github.com/db0company/NextTripTicket    //
// ************************************************************************** //

namespace Api;

require_once('includes/sql.php');
foreach (glob("requests/*.php") as $request)
  require_once($request);
require_once('nmsp/dev.php');

function prettyPrint( $json )
{
  $result = '';
  $level = 0;
  $prev_char = '';
  $in_quotes = false;
  $ends_line_level = NULL;
  $json_length = strlen( $json );

  for( $i = 0; $i < $json_length; $i++ ) {
    $char = $json[$i];
    $new_line_level = NULL;
    $post = "";
    if( $ends_line_level !== NULL ) {
      $new_line_level = $ends_line_level;
      $ends_line_level = NULL;
    }
    if( $char === '"' && $prev_char != '\\' ) {
      $in_quotes = !$in_quotes;
    } else if( ! $in_quotes ) {
      switch( $char ) {
      case '}': case ']':
	$level--;
	$ends_line_level = NULL;
	$new_line_level = $level;
	break;

      case '{': case '[':
	$level++;
      case ',':
	$ends_line_level = $level;
	break;

      case ':':
	$post = " ";
	break;

      case " ": case "\t": case "\n": case "\r":
	$char = "";
	$ends_line_level = $new_line_level;
	$new_line_level = NULL;
	break;
      }
    }
    if( $new_line_level !== NULL ) {
      $result .= "\n".str_repeat( "\t", $new_line_level );
    }
    $result .= $char.$post;
    $prev_char = $char;
  }

  return $result;
}


function	json() {
  header('Content-type:application/json');
  $rsp = get_response();
  global $dev;
  $json = $dev ? prettyPrint(json_encode($rsp)) // todo: why prettyprint not working?
    : json_encode($rsp);
  echo $json;
}

function	error($code, $more = array()) {
  return (array('code' => $code,
		'more' => $more));
}

function	check_params($request, $params) {
  $missing = array();
  $required_params = $request.'_required';
  global $$required_params;
  if (!isset($$required_params))
    return $missing;
  foreach ($$required_params as $required_param)
    if (!array_key_exists($required_param, $params))
      $missing[] = $required_param;
  return $missing;
}

function	set_default_values($request, $params) {
  $default_params = $request.'_default';
  global $$default_params;
  if (!isset($$default_params))
    return $params;
  foreach ($$default_params as $k => $v)
    if (!isset($params[$k]))
      $params[$k] = $v;
  return $params;
}

function	get_response() {
  $request = strtolower($_SERVER['REQUEST_METHOD']).'_'.$_GET['r'];
  $params = $_GET;
  $function = 'ws_'.$request;
  if (!function_exists($function))
    return error('INVALID_REQUEST' /* todo */);
  $missing_params = check_params($request, $params);
  if (!empty($missing_params))
    return error('MISSING_PARAMETERS', $missing_params);
  $params = set_default_values($request, $params);
  return $function($params);
}

