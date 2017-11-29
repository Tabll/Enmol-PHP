<?php



function InsertTo() {
    require dirname(__FILE__).'/../connector/write-connector.php';
    $result = $SQLWriteConnection ->query("");

}