<?php
include_once '../init.php';
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
$twig = getTwig();
$client = new MongoDB\Client("mongodb://zz3f3:easyma@tpmongo-mongodb:27017/?authSource=admin");
$collection = $client->tp->tp;
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