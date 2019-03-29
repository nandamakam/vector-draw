<?php
session_start();
include_once("db.php");
include_once("lib/user.php");
$userID = intval( $_POST['user_id'] );
$fullsize = str_replace( " ", "+", $db->real_escape_string( $_POST['fullsize'] ) );
$thumb = str_replace( " ", "+", $db->real_escape_string( $_POST['thumb'] ) );
$u = new User( "drawapp" );

if( !$u->isLoggedIn( $userID ) ) {
	echo '{ "status": "permission-denied" }';
	exit;
}

$db->query( sprintf( "INSERT INTO drawapp_images ( user_id, data_url ) VALUES ( '%d', '%s' )", $userID, $fullsize ) );
$db->query( sprintf( "INSERT INTO drawapp_thumbs ( user_id, data_url ) VALUES ( '%d', '%s' )", $userID, $thumb ) );

echo '{ "status": "ok" }';
?>
