<?php
    include 'index.php';
    include 'insertNewRow.php';
    insertRow("section");
    header("Location: index.php?fetchsection=true");
?>