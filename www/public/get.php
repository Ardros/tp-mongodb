<?php

include_once '../init.php';

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

$twig = getTwig();
$manager = getMongoDbManager();

// @todo implementez la récupération des données d'une entité et la passer au template
// petite aide : https://github.com/VSG24/mongodb-php-examples
$client = new MongoDB\Client("mongodb://zz3f3:easyma@tpmongo-mongodb:27017/?authSource=admin");
$collection = $client->tp->tp;
$id = $_GET['id'] ?? null;
$entity = null;
if ($id) {
    $entity = $collection->findOne(['objectid' => (int)$id]);
}

// render template
try {
    echo $twig->render('get.html.twig', ['entity' => $entity]);
} catch (LoaderError|RuntimeError|SyntaxError $e) {
    echo $e->getMessage();
}