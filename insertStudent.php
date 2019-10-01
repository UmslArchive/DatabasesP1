<?php
    include 'index.php';
    include 'insertNewRow.php';
    insertRow("student");
    header("Location: index.php?fetchstudent=true");
?>