<?php

require("controlPanel.inc.php");
require("../sessionUtils.inc.php");
require("../database.inc.php");
// sessionRedirectAdminApp();


if (isset($_POST["accept"])){
	approveUser($sql_client, $_POST["ad_id"], $_POST["ad_regid"]);
	unPendingAll($sql_client, $_POST["ad_id"]);
}

// header("Location: /appAdmin/pending");