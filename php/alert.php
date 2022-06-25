<?php
session_start();


// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

//get time task
$sql = "SELECT * FROM todos ORDER BY time_s ASC";
$tasks = mysqli_query($mysqli, $sql);

$last_task = mysqli_fetch_array($tasks);
$todayTimeStamp = time();
$todayTimeStamp = date('Y-m-d', $todayTimeStamp);
$lastTimeStamp = strtotime($last_task['time_s']);
$lastTimeStamp = date('Y-m-d', $lastTimeStamp);

if ($todayTimeStamp === $lastTimeStamp) {
    if (!$last_task['done']) {
        echo $last_task['text'];
    }
}

