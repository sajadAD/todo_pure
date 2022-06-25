<?php
session_start();


// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}

// Include config file
require_once "config.php";

//edit task
if (isset($_POST['text_edit']) && isset($_POST['startDate_edit']) && isset($_POST['endDate_edit'])) {

  $id = $_POST['id'];
  $text = $_POST['text_edit'];
  $start_date = $_POST['startDate_edit'];
  $end_date = $_POST['endDate_edit'];
  $sql = "UPDATE todos SET text = '$text' , time_s = '$start_date' , time_e = '$end_date' WHERE id='$id'";
  mysqli_query($mysqli, $sql);
  header('location: welcome.php');
}
