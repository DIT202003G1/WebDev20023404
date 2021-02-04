<?php
session_start();
require("controlPanel.inc.php");
require("../sessionUtils.inc.php");
require("../database.inc.php");
sessionRedirectAdminApp();


if (!(isset($_POST["accept"]) || isset($_POST["deny"]))){
	header("Location: /appAdmin/pending");
	exit();
}

if (isset($_POST["accept"])){
	approveUser($sql_client, $_POST["ad_id"], $_POST["ad_regid"]);
}
unPendingAll($sql_client, $_POST["ad_id"]);
$id = $_POST['ad_id'];
$regid = $_POST['ad_regid'];
$showReject = ($_GET['showReject'] === 'true') ? "&showReject=true" : "";
header("Location: /appAdmin/pending?id=$id&regid=$regid".$showReject);