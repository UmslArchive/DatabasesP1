<?php
    function insertRow($tableName) {
        global $conn;
        global $username;

        //Build sql statement.
        $count = count($_GET);
        $keys = array_keys($_GET);
        $sql = "INSERT INTO ".$tableName." VALUES (";
        for($i = 0; $i < $count; $i++) {
            if($i !== $count - 1) {
                $sql .= htmlspecialchars($_GET[$keys[$i]]) . ", ";
            }
            else {
                $sql .= htmlspecialchars($_GET[$keys[$i]]) . ")";
            }
        }

        echo $sql;
        echo "<br>".$tableName;
    }
?>