<?php

use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../vendor/autoload.php';

$env      = strtolower(getenv('SYMFONY_ENV') ?: 'prod');
$kernel   = new AppKernel($env, $env !== 'prod');
$request  = Request::createFromGlobals();
$response = $kernel->handle($request)->send();

$kernel->terminate($request, $response);
