<?php

set_include_path(
  getcwd() . PATH_SEPARATOR .
          realpath('../core')
);

require_once 'Application.php';
$configParser = '../../3rd-party/spyc/spyc.php';
$frontController = new Application('../config/config.yaml', $configParser);
$frontController->run();
