<?php
    echo "UPDATE STUDENT<br>";

    $tableName = "student";
    $numColumns = count($_GET) / 2; //count of _get will always be even.
    $i = 0;
    $sql = "UPDATE " . $tableName . " ";

    echo "<br>numColumns = " . $numColumns;

    foreach($_GET as $key => $val) {
        echo "<br>" . $key . "=>" . $val;
    }