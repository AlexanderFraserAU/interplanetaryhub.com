<?php

require_once "classes/Config.php";
require_once "classes/Cookie.php";
require_once "classes/Database.php";
require_once "classes/Hash.php";
require_once "classes/Input.php";
require_once "classes/Link.php";
require_once "classes/Log.php";
require_once "classes/Redirect.php";
require_once "classes/searchEngine.php";
require_once "classes/Session.php";
require_once "classes/Token.php";
require_once "classes/User.php";
require_once "classes/Validate.php";

error_reporting(0); //Lol this is terrible. But i havent got any errors if i cant see them! :) PROBLEMS!
//ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
date_default_timezone_set("UTC");
session_start();
$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => 'localhost',
    'username' => 'interplanetaryhub',
    'password' => 'Warlus123!',
    'db' => 'interplanetaryhub'
  ),
  'remember'	=> array(
    'cookieName'	=> 'HASH',
    'cookieExpiry'	=> 604800,	//1 Week
  ),
  'session'	=> array(
    'sessionName'	=> 'user',
    'tokenName'		=> 'token'
  )
);


spl_autoload_register(function($class) {
  require_once 'classes/'.$class.'.php';
	echo $class;
});


require_once 'functions/sanitize.func.php';

if (Cookie::exists(Config::get('remember/cookieName')) && !Session::exists(Config::get('session/sessionName'))) {
  $hash = Cookie::get(Config::get('remember/cookieName'));
  $hashCheck = Database::getInstance()->get('users_session', array('HASH', '=', $hash));
  if ($hashCheck->count()) {
    $user = new User($hashCheck->index(0)->user_id);
    $user->login();
  }
}
