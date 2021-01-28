<?php

$sql_host = "localhost";
$sql_username = "root";
$sql_password = "";
$sql_tablename = "ACMSPro_Main";

$sql_client = new mysqli($sql_host, $sql_username, $sql_password, $sql_tablename);

if ($sql_client -> connect_errno) {
  echo "Failed to connect to MySQL: " . $sql_client -> connect_error;
  exit();
}