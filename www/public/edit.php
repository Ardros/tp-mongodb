<?php
include_once '../init.php';
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
$twig = getTwig();
$client = new MongoDB\Client("mongodb://{$_ENV['MDB_USER']}:{$_ENV['MDB_PASS']}@{$_ENV['MDB_SRV']}:{$_ENV['MDB_PORT']}/?authSource=admin");
$collection = $client->selectDatabase($_ENV['MDB_DB'])->tp;
$id = $_GET['id'] ?? null;
if (!empty($_POST) && $id) {
	$data = [
		'titre' => $_POST['titre'] ?? '',
		'auteur' => $_POST['auteur'] ?? '',
		'cote' => $_POST['cote'] ?? '',
		'siecle' => $_POST['siecle'] ?? ''
	];
	$collection->updateOne(['objectid' => (int)$id], ['$set' => $data]);
	header('Location: /index.php');
	exit;
} else if ($id) {
	$document = $collection->findOne(['objectid' => (int)$id]);
	try {
		echo $twig->render('edit.html.twig', ['document' => $document]);
	} catch (LoaderError|RuntimeError|SyntaxError $e) {
		echo $e->getMessage();
	}
} else {
	echo 'ID manquant.';
}