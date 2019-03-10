<?php
$action = isset($_POST['action']) ? addslashes(trim($_POST['action'])) : '';
if($action=="update"){
	$version = isset($_POST['version']) ? addslashes(trim($_POST['version'])) : '';
	$version=file_get_contents('http://api.tongleer.com/interface/tongleer.php?action=updateWordPress&version='.$version);
	echo $version;
	exit;
}
?>