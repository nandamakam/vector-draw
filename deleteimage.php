<?php
session_start();
include_once("db.php");
include_once("lib/user.php");
$userID = intval( $_POST['user_id'] );
$imageID = intval( $_POST['image_id'] );
$u = new User( "drawapp" );

if( !$u->isLoggedIn( $userID ) ) {
	echo '{ "status": "permission-denied" }';
	exit;
}

$db->query( sprintf( "DELETE FROM drawapp_images WHERE user_id = '%d' AND id = '%d'", $userID, $imageID ) );
$db->query( sprintf( "DELETE FROM drawapp_thumbs WHERE user_id = '%d' AND id = '%d'", $userID, $imageID ) );

echo '{ "status": "ok" }';
?>
