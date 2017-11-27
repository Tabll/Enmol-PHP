<?php
require dirname(__FILE__) . '/../config/enmol-read-config.php';
require_once dirname(__FILE__) . '/../config/enmol-config.php';
$SQLReadConnection = new mysqli(DB_HOST,DB_USER,DB_READ_PASSWORD,DB_READ_NAME,DB_PORT);
