<?php


$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));

define("DB_HOST", $cleardb_url["host"]);
define("DB_USERNAME", $cleardb_url["user"]);
define("DB_PASSWORD", $cleardb_url["pass"]);
define("DB_DATABASE", substr($cleardb_url["path"], 1));

$active_group = 'default';
$query_builder = TRUE;