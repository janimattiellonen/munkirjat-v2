<?php
$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$response = $kernel->handle($request);

$em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

$tagManager = $kernel->getContainer()->get('fpn_tag.tag_manager');

$conn = $em->getConnection();

$conn->beginTransaction();



$conn->commit();