<?php

include_once '../init.php';

$client = new MongoDB\Client("mongodb://zz3f3:easyma@tpmongo-mongodb:27017/?authSource=admin");
$collection = $client->tp->tp;
$id = $_GET['id'] ?? null;
if ($id) {
	$result = $collection->deleteOne(['objectid' => (int)$id]);
	if ($result->getDeletedCount() === 0) {
		echo "Aucun document supprimé. Vérifiez l'identifiant.";
		exit;
	}
	header('Location: /index.php');
	exit;
} else {
	echo "ID manquant.";
	exit;
}
