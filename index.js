function history() {
  window.location.assign("history.php");
}

$(document).ready(function () {
  $.get("alert.php", function (data, state) {
    if (state == "success") {
      if (data) {
        alert("It's time to do the " + "'" + data + "'" + " task ");
      }
    } else {
      alert("error");
    }
  });
});
function editView(idTask, textTask, timeSTask, timeETask) {
  document.getElementsByName("text")[0].value = textTask;
  document.getElementsByName("startDate")[0].value = timeSTask;
  document.getElementsByName("endDate")[0].value = timeETask;
  document.getElementById(idTask).style.display = "none";
  document.getElementById("edit_btn").style.display = "inline";
  document.getElementById("add_btn").style.display = "none";
  localStorage.setItem("id", idTask);
}
function editSave() {
  var text = document.getElementsByName("text")[0].value;
  var startDate = document.getElementsByName("startDate")[0].value;
  var endDate = document.getElementsByName("endDate")[0].value;
  var id = localStorage.getItem("id");

  var data = {
    id: id,
    text_edit: text,
    startDate_edit: startDate,
    endDate_edit: endDate,
  };
  $.ajax({
    data: data,
    type: "post",
    url: "edit.php",
    success: function (data) {
      console.log("Data Save: " + data);
    },
  });
  window.location.reload();
}
