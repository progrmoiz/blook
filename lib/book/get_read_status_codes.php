<?php
    function get_read_status_code() {
        global $db;

        $sql = "SELECT * FROM `readStatus`";

        $handle = $db->prepare($sql);
        $handle->execute();

        $result = $handle->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }