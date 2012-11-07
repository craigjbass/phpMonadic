<?php

require_once __DIR__.'/Controller/Example.php';
require_once __DIR__.'/../../src/IO.php';

//Simple bootstrap
$controller = new Controller_Example();
$controller->example();
