<?php

include_once '../init.php';

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

$twig = getTwig();
$manager = getMongoDbManager();

// petite aide : https://github.com/VSG24/mongodb-php-examples

if (!empty($_POST)) {
    $client = new MongoDB\Client("mongodb://zz3f3:easyma@tpmongo-mongodb:27017/?authSource=admin");
    $collection = $client->tp->tp;
    $objectid = time() + rand(1, 1000); 
    $data = [
        'objectid' => $objectid,
        'titre' => $_POST['titre'] ?? '',
        'auteur' => $_POST['auteur'] ?? '',
        'cote' => $_POST['cote'] ?? '',
        'siecle' => $_POST['siecle'] ?? ''
    ];
    $collection->insertOne($data);
    header('Location: /index.php');
    exit;
} else {
// render template
    try {
        echo $twig->render('create.html.twig');
    } catch (LoaderError|RuntimeError|SyntaxError $e) {
        echo $e->getMessage();
    }
}

