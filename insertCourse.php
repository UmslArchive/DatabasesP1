<?php
    include 'index.php';
    include 'insertNewRow.php';
    insertRow("course");
    header("Location: index.php?fetchcourse=true");
?>