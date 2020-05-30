<?php
session_start();
$GLOBALS['config'] = array(
  'mysql' => array(
    'host' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'db' => 'webscapeusers'
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
});

require_once 'functions/sanitize.func.php';

if (Cookie::exists(Config::get('remember/cookieName')) && !Session::exists(Config::get('session/sessionName'))) {
  $hash = Cookie::get(Config::get('remember/cookieName'));
  $hashCheck = Database::getInstance()->get('users_session', array('HASH', '=', $hash));
  if ($hashCheck->count()) {
    $user = new User($hashCheck->first()->user_id);
    $user->login();
  }
}
