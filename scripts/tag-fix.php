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
$sql = 'SELECT id, name FROM genre';

$stmt = $conn->prepare($sql);
$stmt->execute();

$genres = $stmt->fetchAll();

$insert = 'INSERT INTO xi_tag (id, name, slug, created_at, updated_at) VALUES (:id, :name, :slug, :ca, :ua)';

$date = new \DateTime();

foreach($genres as $row) {

    $stmt = $conn->prepare($insert);
    $stmt->bindValue('id', $row['id']);
    $stmt->bindValue('name', $row['name']);
    $stmt->bindValue('slug', $row['name']);
    $stmt->bindValue('ca', $date->format('Y-m-d H:i:s'));
    $stmt->bindValue('ua', $date->format('Y-m-d H:i:s'));
    $stmt->execute();
}


$sql2 = 'SELECT book_id, genre_id FROM book_genre';
$stmt = $conn->prepare($sql2);
$stmt->execute();

$results = $stmt->fetchAll();

$insert2 = 'INSERT INTO xi_tagging (tag_id, resource_type, resource_id, created_at, updated_at) VALUES (:tagId, :resourceType, :resourceId, :ca, :ua)';

foreach($results as $row) {
    $stmt = $conn->prepare($insert2);
    $stmt->bindValue('tagId', $row['genre_id']);
    $stmt->bindValue('resourceId', $row['book_id']);
    $stmt->bindValue('resourceType', 'book');
    $stmt->bindValue('ca', $date->format('Y-m-d H:i:s'));
    $stmt->bindValue('ua', $date->format('Y-m-d H:i:s'));
    $stmt->execute();
}

$conn->commit();







