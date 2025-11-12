<?php

include_once '../init.php';

$client = new MongoDB\Client("mongodb://{$_ENV['MDB_USER']}:{$_ENV['MDB_PASS']}@{$_ENV['MDB_SRV']}:{$_ENV['MDB_PORT']}/?authSource=admin");
$collection = $client->selectDatabase($_ENV['MDB_DB'])->tp;
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
