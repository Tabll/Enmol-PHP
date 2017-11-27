<?php
require dirname(__FILE__) . '/../config/enmol-write-config.php';
require_once dirname(__FILE__) . '/../config/enmol-config.php';
$SQLWriteConnection = new mysqli(DB_HOST,DB_WRITE_USER,DB_WRITE_PASSWORD,DB_WRITE_NAME,DB_PORT);
