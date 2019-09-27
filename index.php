<!DOCTYPE html>
<html lang="en">
<head>
  <title>Project 1</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="clickEventFunctions.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-sm bg-dark justify-content-center">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" id="studentButton" href='index.php?fetchStudent=true'>Student</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="courseButton" href='index.php?fetchCourse=true'>Course</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="sectionButton" href='index.php?fetchSection=true'>Section</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="grade_reportButton" href='index.php?fetchGrade=true'>Grade Report</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="prerequisiteButton" href='index.php?fetchPrereq=true'>Prerequisite</a>
    </li>
  </ul>
</nav>
<br>

<?php
  //Global db connection variables.
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "p1";
  $conn = NULL;

  //Global table properties variables.
  $numRows = NULL;
  $numCols = NULL;

  function connectToDatabase() {
    global $servername, $username, $password, $dbname, $conn;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
  }

  //Fetch functions.
  function fetchTable($tableName) {
    global $conn;

    //Apply styles.
    echo 
      "<style>
        #".$tableName."Button {
          color: orange;
          font-size: 110%;
          font-weight: bold;
        }

        table {
          width: 50%;
          margin: auto;
        }

        th, td {
          border: 1px solid black;
          border-collapse: collapse;
        }

        .buttonRow {
          border: 0px;
        }

        .buttonColumn {
          border: 0px;
        }
      </style>";

    //Execute table selection query.
    connectToDatabase();
    $fields = array();
    $queryString = "select * from ".$tableName;
    if($result = $conn->query($queryString)) {
      //Fetch the header field names and push into fields array.
      while($fieldInfo = $result->fetch_field()) {
        array_push($fields, $fieldInfo->name);
      }

      //Print non-empty table.
      if($result->num_rows > 0) {
        //Table header.
        echo "<table id=\"currentTable\"><tr>";
        foreach($fields as &$name) {
          echo "<th>".$name."</th>";
        }
        echo "</tr>";

        //Tuples(rows).
        echo "<tr>";
        for($j = 0; $j < $result->num_rows; $j++) {
          $row = mysqli_fetch_assoc($result);

          //Data
          for($i = 0; $i < count($fields); $i++) {
            echo "<td>".$row[$fields[$i]]."</td>";
          }

          //Append buttons to end of row.
          echo "<td class=\"buttonColumn\"> <button id=editButton".$j.">Edit</button> </td> <td class=\"buttonColumn\"> <button class=\"deleteButtons\" id=deleteButton".$j.">Delete</button> </td> </tr>";
        }

        //Add sort buttons.
        echo "<tr>";
        for($i = 0; $i < count($fields); $i++) {
          echo "<td class=\"buttonRow\"> <button id=sortAscendingButton".$i.">Up</button> <button id=sortDescendingButton".$i.">Down</button> </td>";
        }
        echo "</tr>";
        
        //End of table.
        echo "</tr></table>";

        //Placed the button in a div, so javascript can change the innerHTML of the div on click.
        echo "<br><br>";
        echo "<div id=\"updateDiv\"> <button onclick=\"newRowClicked()\" id=\"newRowButton\">New Row</button> </div>";
      }      
    }
  }

  function fetchCourse() {
    echo 'course';
  }

  function fetchSection() {
    echo 'section';
  }

  function fetchGrade() {
    echo 'grade';
  }

  function fetchPrereq() {
    echo 'prerequisite';
  }

  //Entry point.
  if (isset($_GET['fetchStudent'])) {
    fetchTable("student");
  }
  if (isset($_GET['fetchCourse'])) {
    fetchTable("course");
  }
  if (isset($_GET['fetchSection'])) {
    fetchTable("section");
  }
  if (isset($_GET['fetchGrade'])) {
    fetchTable("grade_report");
  }
  if (isset($_GET['fetchPrereq'])) {
    fetchTable("prerequisite");
  }
?>