<?php

use Symfony\Component\HttpFoundation\Request;

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__ . '/../app/autoload.php';
include_once __DIR__ . '/../var/bootstrap.php.cache';

// Enable APC for autoloading to improve performance.
$apcLoader = new Symfony\Component\ClassLoader\ApcClassLoader(sha1('phpdocker.io' . __FILE__), $loader);
$loader->unregister();
$apcLoader->register(true);

// Load up app kernel in production mode
$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();

// Request/Response
$request  = Request::createFromGlobals();
$response = $kernel->handle($request)->send();

$kernel->terminate($request, $response);
