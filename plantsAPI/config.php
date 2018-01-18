<?php

$args = array(
	'name' => 'plant',
	'username' => 'root',
	'password' => '',
	'server' => 'localhost',
	'port' => 3306,
	'type' => 'mysql',
	'table_blacklist' => array(),
	'column_blacklist' => array(),
);

register_db_api('plant', $args);
