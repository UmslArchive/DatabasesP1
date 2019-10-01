<?php
    include 'index.php';
    include 'insertNewRow.php';
    insertRow("prerequisite");
    header("Location: index.php?fetchprerequisite=true");
?>