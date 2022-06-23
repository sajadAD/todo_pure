<?php
// Initialize the session
session_start();

// initialize errors variable
$errors = "Insert TODO";
$editTask = true;

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}

// Include config file
require_once "config.php";

//insert a quote if submit button is clicked
if (isset($_POST['submit'])) {
  if (empty($_POST['text']) && empty($_POST['startDate']) && empty($_POST['endDate'])) {
    $errors = "You must fill in the task";
  } else {
    $text = $_POST['text'];
    $start_date = $_POST['startDate'];
    $end_date = $_POST['endDate'];
    $sql = "INSERT INTO todos VALUES ('null','$text','$_SESSION[id]','$start_date','$end_date','false')";
    mysqli_query($mysqli, $sql);
    header('location: welcome.php');
  }
}
// delete task
if (isset($_GET['del_task'])) {
  $id = $_GET['del_task'];

  mysqli_query($mysqli, "DELETE FROM todos WHERE id=" . $id);
  header('location: welcome.php');
}

// done task
if (isset($_GET['done_task'])) {
  $id = $_GET['done_task'];

  mysqli_query($mysqli, "UPDATE todos SET done = true WHERE id=" . $id);
  header('location: welcome.php');
}
// undone task
if (isset($_GET['Undone_task'])) {
  $id = $_GET['Undone_task'];

  mysqli_query($mysqli, "UPDATE todos SET done = false WHERE id=" . $id);
  header('location: welcome.php');
}
// edit task
if (isset($_GET['edit_task'])) {
  $editTask = !$editTask;
}

if (isset($_POST['id']) && isset($_POST['value'])) {
  $id = $_POST['id'];
  $value = $_POST['value'];
  mysqli_query($mysqli, "UPDATE todos SET done = $value WHERE id=" . $id);
  header('location: welcome.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
  <link rel="stylesheet" href="../style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
  <div class="top_welcome">
    <h1>Hi,<span class="username"><?php echo htmlspecialchars($_SESSION["username"]); ?></span> Welcome to our site.</h1>
    <p>
      <a href="logout.php" class="btn-danger">Sign Out</a>
    </p>
  </div>
  <div class="todos">
    <div class="card">
      <div class="head">
        <h2>To Do List</h2>
      </div>
      <div class="main_card">
        <?php if (isset($errors)) { ?>
          <p id="error"><?php echo $errors ?></p>
        <?php } ?>
        <form method="post" action="welcome.php">
          <div class="form-group">
            <label for="title">Task:</label>
            <input type="text" name="text" class="form-control" placeholder="Add a title... ">
          </div>
          <div class="form-group">
            <label for="usr">Start Date:</label>
            <input type="date" name="startDate" id="due-date" class="form-control" placeholder="Due date">
          </div>
          <div class="form-group">
            <label for="usr">End Date:</label>
            <input type="date" name="endDate" id="due-date" class="form-control" placeholder="Due date">
          </div>
          <div class="row">
            <div class="col-xs-3 pull-left">
              <button type="submit" name="submit" id="add_btn" class="btn btn-primary">Add Task</button>
            </div>
          </div>
        </form>
      </div>
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
        $tasks = mysqli_query($mysqli, "SELECT * FROM todos WHERE uid = $_SESSION[id]");

        $i = 1;
        while ($row = mysqli_fetch_array($tasks)) { ?>
          <tr>
            <td> <?php echo $i; ?> </td>
            <td class="task" style="<?php if ($row['done']) echo 'text-decoration: line-through;' ?>"> <?php echo $row['text']; ?> </td>
            <td class="task" style="<?php if ($row['done']) echo 'text-decoration: line-through;' ?>"> <?php echo $row['time_s']; ?> </td>
            <td class="task" style="<?php if ($row['done']) echo 'text-decoration: line-through;' ?>"> <?php echo $row['time_e']; ?> </td>
            <td>
              <!-- <a class="done" style="<?php if ($row['done']) echo 'display: none;' ?>" href="welcome.php?done_task=<?php echo $row['id'] ?>">Done</a> -->
              <input name="<?php echo $row['text']; ?>" id="<?php echo $row['id']; ?>" onclick="changeState(this)" type="checkbox" <?php if ($row['done']) echo 'checked'; ?> value="<?php if($row['done']) echo 0; else echo 1; ?>">
              <!-- <a class="edit" style="<?php if (!$row['done']) echo 'display: none;' ?>" href="welcome.php?Undone_task=<?php echo $row['id'] ?>">UnDone</a> -->
              <a class="delete" style="<?php if ($row['done']) echo 'display: none;' ?>" href="welcome.php?del_task=<?php echo $row['id'] ?>">delete</a>
            </td>
          </tr>
        <?php $i++;
        } ?>
      </tbody>
    </table>
  </div>
</body>
<script>
  function changeState(currTask) {
    var value = currTask.getAttribute("value");
    var id = currTask.getAttribute("id");

    $.post("welcome.php", {
      id: id,
      value: value
    }, (text) => {
      window.location.reload();
    });

  }
</script>

</html>