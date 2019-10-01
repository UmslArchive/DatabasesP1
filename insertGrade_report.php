<?php
    include 'index.php';
    include 'insertNewRow.php';
    insertRow("grade_report");
    header("Location: index.php?fetchgrade_report=true");
?>