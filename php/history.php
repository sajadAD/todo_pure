<?php


// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
  }

// Include config file
require_once "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="../style.css">
    <title>Document</title>
</head>
<body>
    
  <div class="top_welcome">
    <h1>Hi,<span class="username"><?php echo htmlspecialchars($_SESSION["username"]); ?></span> Welcome to our site.</h1>
    <p>
      <a href="welcome.php" class="btn-danger">back</a>
    </p>
  </div>
    
<table>
      <thead>
        <tr>
          <th style="max-width: 10%;">list</th>
          <th style="max-width: 30%;">Tasks</th>
          <th style="max-width: 20%;">Time Start</th>
          <th style="max-width: 20%;">Time End</th>
          <th style="max-width: 20%;">Action</th>
        </tr>
      </thead>

      <tbody>
        <?php
        // select all tasks if page is visited or refreshed
        $tasks = mysqli_query($mysqli, "SELECT * FROM todos WHERE uid = $_SESSION[id] AND done = 1");

        $i = 1;
        while ($row = mysqli_fetch_array($tasks)) { ?>
          <tr>
            <td> <?php echo $i; ?> </td>
            <td class="task" style="<?php if ($row['done']) echo 'text-decoration: line-through;' ?>"> <?php echo $row['text']; ?> </td>
            <td class="task" style="<?php if ($row['done']) echo 'text-decoration: line-through;' ?>"> <?php echo $row['time_s']; ?> </td>
            <td class="task" style="<?php if ($row['done']) echo 'text-decoration: line-through;' ?>"> <?php echo $row['time_e']; ?> </td>
            <td>
              <a class="done" style="<?php if ($row['done']) echo 'display: none;' ?>" href="welcome.php?done_task=<?php echo $row['id'] ?>">Done</a>
              <a class="edit" style="<?php if (!$row['done']) echo 'display: none;' ?>" href="welcome.php?Undone_task=<?php echo $row['id'] ?>">UnDone</a>
              <!-- <a class="delete" style="<?php if ($row['done']) echo 'display: none;' ?>" href="welcome.php?del_task=<?php echo $row['id'] ?>">delete</a> -->
            </td>
          </tr>
        <?php $i++;
        } ?>
      </tbody>
    </table>
</body>
</html>