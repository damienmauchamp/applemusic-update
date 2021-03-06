<?php
require dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . "/start.php";

use AppleMusic\Artist as Artist;
use AppleMusic\DB as db;

$artists = isset($_GET["artists"]) ? $_GET["artists"] : null;
$userToken = $_GET['userToken'] ?? $_POST['userToken'] ?? null;
$userId = $_SESSION['id_user'] ?? null;

//
if ($userId === null && $userToken !== null) {
	//
	$userInfos = (new db)->getUserFromUserToken($userToken);
	if (!$userInfos) {
		$userToken = null;
	} else {
        $userId = (int) $userInfos['id'];
    }
}


// Unauthorized
if (!($userToken ?? $userId ?? false)) {
    http_response_code(404);
    exit();
}

$results = [
    'artists' => [],
    'infos' => [
        'userToken' => $userToken,
        'userId' => $userId,
    ],
];
foreach (($artists ?? []) as $id) {

    $artistId = trim($id);
    if (!preg_match('/^\d+$/', $artistId)) {
        $results['artists'][] = [
            'id' => $artistId,
            'name' => null,
            'added' => false,
            'fetch' => null,
            'message' => 'Not an ID',
        ];
        continue;
    }

    $artist = new Artist($artistId);
    $fetchInfos = $artist->fetchArtistInfo();
    $added = $artist->addArtist($userId);
    $results['artists'][] = [
        'id' => $artistId,
        'name' => $artist->getName() ?? '',
        'added' => $added,
        'fetch' => $fetchInfos,
        'message' => !$added ? 'Something went wrong' : '',
    ];
}

echo json_encode($results);