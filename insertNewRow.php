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

        if($result !== TRUE) {
            echo "Error: <br>" . $conn->error;
        }

        mysqli_close($conn);

        fetchTable($tableName);

        //Placed the new row button in a div, so javascript can change the innerHTML of the div on click.
        echo "<br><br>";
        echo "<div id=\"updateDiv\"> <button onclick=newRowClicked(\"" . $GLOBALS["page"] . "\") id=\"newRowButton\">New Row</button> </div>";
    }
?>