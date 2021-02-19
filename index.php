<?php

require_once 'vendor/autoload.php';
require_once 'autoloader.php';

use powerpush\powerframe\core\PowerframeApplication;

$app = new PowerframeApplication();

$app->cors->all();

$app->get("/", function() {
    
});

$app->run();

?>