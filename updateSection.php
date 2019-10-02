<?php
    
    include 'index.php';

    global $conn;
    connectToDatabase();

    $tableName = "section";
    $numColumns = count($_GET) / 2; //count of _get will always be even.
    $i = 0;
    $keys = array_keys($_GET);

    //Build sql query string.
    $sql = "UPDATE " . $tableName . " SET ";

    foreach($_GET as $key => $val) {
        //New vals. (set values)
        if($i < $numColumns) {
            if($i !== $numColumns - 1)
                $sql .= $keys[$i % $numColumns] . "='" . $_GET[$keys[$i % $numColumns]] . "', ";
            else
                $sql .= $keys[$i % $numColumns] . "='" . $_GET[$keys[$i % $numColumns]] . "' WHERE ";
        }

        //Old vals (where conditions)
        else if($i >= $numColumns && $i < $numColumns * 2) {
            if($i % $numColumns !== $numColumns - 1)
                $sql .= htmlspecialchars($keys[$i % $numColumns]) . "='" . htmlspecialchars($_GET[$keys[$i]]) . "' AND ";
            else
                $sql .= htmlspecialchars($keys[$i % $numColumns]) . "='" . htmlspecialchars($_GET[$keys[$i]]) . "'";
        }
        $i++;
    }

    //Debug
    /* echo "<br>numColumns = " . $numColumns;

    foreach($_GET as $key => $val) {
        echo "<br>" . $key . "=>" . $val;
    }

    echo "<br><br>sql = " . $sql; */

    $result = $conn->query($sql);

    echo "<br>";
    if ($result === TRUE) {
        echo "'" . $tableName . "' table was updated successfully.";
    } 
    else {
        echo "Error updating a row: " . $conn->error;
    }



