<?php
    $KEY = isset($_POST['my-test-key']) ? $_POST['my-test-key'] : "";
    if (empty($KEY) || $KEY != 'HA22GU46aGIU784QF1DV') {
        exit();
    }
    require '../../ENMOL/connector/read-connector.php';
    require '../../ENMOL/connector/write-connector.php';
    require '../../ENMOL/connector/redis-connector.php';
    $warning = '';
    if (!$SQLReadConnection) {
        $warning .= "数据库连接错误:".mysqli_connect_error();
    }
    if (!$SQLWriteConnection) {
        $warning .= "数据库连接错误:".mysqli_connect_error();
    }
    if ($warning == '') {
        $warning = 'MySQL数据库连接正常';
    }
    $redisState = $RedisConnection ? 'Redis数据库连接正常<br>Redis主机名：'.REDIS_HOST.'<br>Redis端口：'.REDIS_PORT : '与Redis数据库建立连接失败';
    echo "连接测试"."<br>".
        "<br>".$redisState.
        "<br>".
        "<br>客户端版本：".mysqli_get_client_info().
        "<br>".
        "<br>".$warning.
        "<br>".
        "<br>只读SQL客户端库版本：".mysqli_get_client_version($SQLReadConnection).
        "<br>只读SQL服务器内网地址和连接类型：".mysqli_get_host_info($SQLReadConnection).
        "<br>只读SQL协议版本：".mysqli_get_proto_info($SQLReadConnection).
        "<br>只读SQL服务器版本：".mysqli_get_server_info($SQLReadConnection).
        "<br>只读SQL服务器版本号：".mysqli_get_server_version($SQLReadConnection).
        "<br>".
        "<br>读写SQL客户端库版本：".mysqli_get_client_version($SQLWriteConnection).
        "<br>读写SQL服务器内网地址和连接类型：".mysqli_get_host_info($SQLWriteConnection).
        "<br>读写SQL协议版本：".mysqli_get_proto_info($SQLWriteConnection).
        "<br>读写SQL服务器版本：".mysqli_get_server_info($SQLWriteConnection).
        "<br>读写SQL服务器版本号：".mysqli_get_server_version($SQLWriteConnection);
