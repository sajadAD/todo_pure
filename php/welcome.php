<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
  <div class="container">
    <div class="jumbotron page-header">
      <h2 style="margin:5px">My To Do List</h2>
    </div>
    <form>
      <div class="form-group">
        <label for="title">Task:</label>
        <input type="text" id="title" class="form-control" placeholder="Add a title... ">
      </div>
      <div class="form-group">
        <label for="usr">Who should do it:</label>
        <input type="text" id="usr" class="form-control" placeholder="Add a user...">
      </div>
      <div class="form-group">
        <label for="usr">Due Date:</label>
        <input type="date" id="due-date" class="form-control" placeholder="Due date">
      </div>
      <div class="row">
        <div class="col-xs-3 pull-left">
          <button type="button" class="btn btn-primary" onclick="newElement()">Add Task</button>
        </div>
      </div>
    </form>
  </div>
  <div class="tasks">
    <ul id="task-list">
    </ul>
  </div>
  <ul id="pagination" class="pagination pagination-lg"></ul>
  <script src="../index.js">  </script>
</body>
</html>