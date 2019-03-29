<?php
session_start();
include_once("db.php");
include_once("lib/user.php");
$userID = intval( $_GET['user_id'] );
$u = new User( "drawapp" );

if( !$u->isLoggedIn( $userID ) ) {
	echo '{ "status": "permission-denied" }';
	exit;
}

if( $result = $db->query( sprintf( "SELECT i.id as id, i.data_url as image_url, t.data_url as thumb_url FROM drawapp_images as i, drawapp_thumbs as t WHERE i.user_id = '%d' AND t.user_id = i.user_id AND t.id = i.id ORDER BY i.id DESC", $userID ) ) ) {
	echo '{ "status": "ok", "images": [';
	$i = 0;
	$num = $result->num_rows;
	while( $image = $result->fetch_object() ) {
		
		echo '{ "id": "'.$image->id.'", "fullsize": "'.$image->image_url.'", "thumbnail": "'.$image->thumb_url.'" }'.($i < $num-1 ? ', ' : '');
		$i++;
	}
	
	echo '] }';
	
} else {
	echo '{ "status": "no-images" }';
	exit;
}
?>
