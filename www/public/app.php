<?php

include_once '../init.php';

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

$twig = getTwig();
$manager = getMongoDbManager();

// @todo implementez la récupération des données dans la variable $list
// petite aide : https://github.com/VSG24/mongodb-php-examples
$collection = (new MongoDB\Client("mongodb://zz3f3:easyma@tpmongo-mongodb:27017/?authSource=admin"))->tp->tp;

$page = $_GET['page'] ?? 1;
$search = $_GET['search'] ?? '';
$limit = 10; 
$skip = ($page - 1) * $limit;

$query = [];
if ($search) {
    $query['titre'] = ['$regex' => $search, '$options' => 'i'];
}

$list = $collection->find($query, ['skip' => $skip, 'limit' => $limit])->toArray();
$total = $collection->countDocuments($query);
$totalPages = ceil($total / $limit);

// render template
try {
    echo $twig->render('index.html.twig', ['list' => $list, 'page' => $page, 'totalPages' => $totalPages, 'search' => $search]);
} catch (LoaderError|RuntimeError|SyntaxError $e) {
    echo $e->getMessage();
}



