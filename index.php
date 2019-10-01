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
      <a class="nav-link" id="studentButton" href='index.php?fetchstudent=true'>Student</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="courseButton" href='index.php?fetchcourse=true'>Course</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="sectionButton" href='index.php?fetchsection=true'>Section</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="grade_reportButton" href='index.php?fetchgrade_report=true'>Grade Report</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="prerequisiteButton" href='index.php?fetchprerequisite=true'>Prerequisite</a>
    </li>
  </ul>
</nav>
<br>

<?php
  //Global db connection variables.
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "p1";
  $conn = NULL;

  //Global table properties variables.
  $numRows = NULL;
  $numCols = NULL;

  //Global page tracker.
  $GLOBALS["page"] = NULL;

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

        #updateDiv {
          margin: auto;
          width: 50%;
        }

        a.button {
          padding: 3px;
          -webkit-appearance: button;
          -moz-appearance: button;
          appearance: button;
      
          text-decoration: none;
          color: initial;
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

        $pKeys = NULL; //Used to store a tables primary key value at a row.
        echo "<tr>";
        //Build the table.
        for($j = 0; $j < $result->num_rows; $j++) { //for each row
          $row = mysqli_fetch_assoc($result);

          //Data cells.
          for($i = 0; $i < count($fields); $i++) { //for each column
            //Primary key storage.
            if($tableName === "student" && $i === 0) {
              $pKeys = $row[$fields[$i]];
            }
            if($tableName === "course" && $i === 0) {
              $pKeys = $row[$fields[$i]];
            }
            if($tableName === "section" && $i === 0) {
              $pKeys = $row[$fields[$i]];
            }
            if($tableName === "prerequisite" && $i === 0) {
              $pKeys = $row[$fields[$i]];
            }
            if($tableName === "grade_report" && $i === 0) {
              $pKeys = $row[$fields[$i]] . "&sid=".$row[$fields[$i + 1]];
            }

            echo "<td>".$row[$fields[$i]]."</td>";
          }

          //Append buttons to end of row.
          echo  "<td class=\"buttonColumn\">".
                  "<a class=\"button\" href=\"index.php?fetch" . $GLOBALS["page"] . "=true&editRow=" . $pKeys . "\">Edit</a>".
                "</td>".
                "<td class=\"buttonColumn\">".
                  "<a class=\"button\" href=\"index.php?fetch" . $GLOBALS["page"] . "=true&deleteRow=" . $pKeys . "\">Delete</a>".
                "</td> </tr>";
        }

        //Add sort buttons.
        echo "<tr>";
        for($i = 0; $i < count($fields); $i++) {
          echo "<td class=\"buttonRow\"> <button id=sortAscendingButton".$i.">Up</button> <button id=sortDescendingButton".$i.">Down</button> </td>";
        }
        echo "</tr>";
        
        //End of table.
        echo "</tr></table>";
      }
      else {
        //query failed.
        echo "<br>Query failed. Table is probably empty, so everything breaks.";
        echo "<br>If the tables aren't empty, try changing the \$password variable to \"root\" or empty string.";
      }

      //close the connection.
      mysqli_close($conn);
    }
  }


  function deleteRow($tableName, $pKeyName) {
    global $conn;
    connectToDatabase();
    if($conn->connect_error) {
      die("Connection Failed: " . $conn->connect_error);
    }

    if(is_array($pKeyName)) {
      foreach($pKeyName as $pkeyElement) {
        echo $pkeyElement;
        echo "<br>";
      }
    }      

    //Build the query string.
    $sql = "DELETE FROM ".$tableName." WHERE ".$pKeyName."='".$_GET["deleteRow"]."'";
    echo $sql;

    //Execute the deleteion query.
    if ($conn->query($sql) === TRUE) {
      echo "Record deleted successfully";
    } else {
      echo "Error deleting record: " . $conn->error;
    }
  
    $conn->close();
    
  }
  
  //STUDENT
  if (isset($_GET['fetchstudent'])) {
    $GLOBALS["page"] = "student";

    //Update tables before display.
    if(isset($_GET["deleteRow"])) {
      deleteRow("student", "student_number");
    }
    
    //Display table and load the webpage.
    fetchTable("student");

    //Placed the new row button in a div, so javascript can change the innerHTML of the div on click.
    echo "<br><br>";
    echo "<div id=\"updateDiv\"> <button onclick=newRowClicked(\"" . $GLOBALS["page"] . "\") id=\"newRowButton\">New Row</button> </div>";
  }

  //COURSE
  if (isset($_GET['fetchcourse'])) {
    $GLOBALS["page"] = "course";

    //Update.
    if(isset($_GET["deleteRow"])) {
      deleteRow("course", "course_number");
    }

    fetchTable("course");

    //Placed the new row button in a div, so javascript can change the innerHTML of the div on click.
    echo "<br><br>";
    echo "<div id=\"updateDiv\"> <button onclick=newRowClicked(\"" . $GLOBALS["page"] . "\") id=\"newRowButton\">New Row</button> </div>";
  }

  //SECTION
  if (isset($_GET['fetchsection'])) {
    $GLOBALS["page"] = "section";

    //Update.
    if(isset($_GET["deleteRow"])) {
      deleteRow("section", "section_identifier");
    }

    fetchTable("section");

    //Placed the new row button in a div, so javascript can change the innerHTML of the div on click.
    echo "<br><br>";
    echo "<div id=\"updateDiv\"> <button onclick=newRowClicked(\"" . $GLOBALS["page"] . "\") id=\"newRowButton\">New Row</button> </div>";
  }

  //GRADE_REPORT
  if (isset($_GET['fetchgrade_report'])) {
    $GLOBALS["page"] = "grade_report";

    //Update.
    if(isset($_GET["deleteRow"])) {
      $pkey = array("student_number", "section_identifier");
      deleteRow("grade_report", $pkey);
    }

    fetchTable("grade_report");

    //Placed the new row button in a div, so javascript can change the innerHTML of the div on click.
    echo "<br><br>";
    echo "<div id=\"updateDiv\"> <button onclick=newRowClicked(\"" . $GLOBALS["page"] . "\") id=\"newRowButton\">New Row</button> </div>";
  }

  //PREREQ
  if (isset($_GET['fetchprerequisite'])) {
    $GLOBALS["page"] = "prerequisite";

    //Update.
    if(isset($_GET["deleteRow"])) {
      deleteRow("prerequisite");
    }
    
    fetchTable("prerequisite");

    //Placed the new row button in a div, so javascript can change the innerHTML of the div on click.
    echo "<br><br>";
    echo "<div id=\"updateDiv\"> <button onclick=newRowClicked(\"" . $GLOBALS["page"] . "\") id=\"newRowButton\">New Row</button> </div>";
  }
?>