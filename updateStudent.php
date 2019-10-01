<?php
    include "index.php";

    //Connect to the db.
    global $conn;
    connectToDatabase();

    //Build sql query string.
    $tableName = "student";
    $count = 0;
    $total = count($_GET);
    $keys = array_keys($_GET);
    $sql = "UPDATE " . $tableName . " SET ";
    foreach($_GET as $key => $val) {
        if($count < $total - 1)
            $sql .= $key . "='" . $val . "', ";
        else
            $sql .= $key . "='" . $val . "' ";

        $count++;
    }

    $sql .= "WHERE blank";

    echo "<br>" . $sql;
?>