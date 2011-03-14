<?php

use \Core\Application as Application;

setlocale('LC_ALL', 'ru_RU');
date_default_timezone_set('Europe/Moscow');

$application = new Application('../App/config.json');
$application->run();

function __autoload($class) {
  $class = '../' . str_replace('\\', '/', $class) . '.php';
  require_once($class);
}



