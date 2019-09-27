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
      <a class="nav-link" id="gradeButton" href='index.php?fetchGrade=true'>Grade Report</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="prerequisiteButton" href='index.php?fetchPrereq=true'>Prerequisite</a>
    </li>
  </ul>
</nav>
<br>

<?php
  //Global Variables
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "p1";
  $conn = NULL;

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
  function fetchStudent() {
    global $conn;

    //Make studentButton orange.
    echo 
      '<style>
        #studentButton {
          color: orange;
          font-size: 110%;
          font-weight: bold;
        }
      </style>';

    connectToDatabase();

    //Execute SQL query.
    $fields = array();
    $queryString = "select * from student";
    if($result = $conn->query($queryString)) {
      //Fetch the header field names and push into fields array.
      while($fieldInfo = $result->fetch_field()) {
        array_push($fields, $fieldInfo->name);
      }

      foreach($fields as &$name) {
        echo $name." ";
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
    fetchStudent();
  }
  if (isset($_GET['fetchCourse'])) {
    fetchCourse();
  }
  if (isset($_GET['fetchSection'])) {
    fetchSection();
  }
  if (isset($_GET['fetchGrade'])) {
    fetchGrade();
  }
  if (isset($_GET['fetchPrereq'])) {
    fetchPrereq();
  }
?>