<?php
    function insertRow($tableName) {
        global $servername, $username, $password, $dbname, $conn;
        connectToDatabase();

        //Build sql statement.
        $count = count($_GET);
        $keys = array_keys($_GET);
        $sql = "INSERT INTO ".$tableName." VALUES (";
        for($i = 0; $i < $count; $i++) {
            if($i !== $count - 1) {
                $sql .= "'".htmlspecialchars($_GET[$keys[$i]]) . "', ";
            }
            else {
                $sql .= "'".htmlspecialchars($_GET[$keys[$i]]) . "')";
            }
        }
        $result = $conn->query($sql);

        echo "<br>";
        if ($result === TRUE) {
            echo "'" . $tableName . "' table was inserted into successfully.";
        } 
        else {
            echo "Error inserting a new row: " . $conn->error;
        }
        
        mysqli_close($conn);
    }
?>