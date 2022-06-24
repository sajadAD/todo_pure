function history() {
  window.location.assign("history.php");
}

function editView(currTask) {
  var id = currTask.getAttribute('id')
  document.getElementById('done_'+id).style.display = "none"
  document.getElementById(id).style.display = "none"
  document.getElementById('delete_'+id).style.display = "none"
  document.getElementById('text_edit_'+id).style.display = "none"
  document.getElementById('save_'+id).style.display = "inline"
  document.querySelector(".form-control-edit").style.display = "block"
  document.querySelector(".edit_td").style.display = "block"
}
