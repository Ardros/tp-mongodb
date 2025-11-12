<?php

include_once '../init.php';

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

$twig = getTwig();
$manager = getMongoDbManager();

// petite aide : https://github.com/VSG24/mongodb-php-examples

if (!empty($_POST)) {
    $client = new MongoDB\Client("mongodb://{$_ENV['MDB_USER']}:{$_ENV['MDB_PASS']}@{$_ENV['MDB_SRV']}:{$_ENV['MDB_PORT']}/?authSource=admin");
    $collection = $client->selectDatabase($_ENV['MDB_DB'])->tp;
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

