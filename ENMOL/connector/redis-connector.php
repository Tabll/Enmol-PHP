<?php
require dirname(__FILE__) . '/../config/enmol-redis-config.php';
$RedisConnection = new Redis();
$RedisConnection -> connect(REDIS_HOST,REDIS_PORT);
