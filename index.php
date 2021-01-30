<?php
require_once 'includes/config.php';
require_once 'includes/notificationClass.php';
if(isset($_POST['title']) && !empty($_POST['title'])){
   new NotificationClass();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Push Notification </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Push </h2>
  <div class="alert alert-primary" role="alert" style="display:none">
  Notification send successfully!
</div>
  <form action="/action_page.php" class="needs-validation" novalidate>
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" class="form-control" id="title" placeholder="Enter Title" name="title" required>
      <div class="invalid-feedback">Please enter the title.</div>
    </div>
    <div class="form-group">
      <label for="description">Description:</label>
      <input type="text" class="form-control" id="description" placeholder="Description" name="description" required>
      <div class="invalid-feedback">Please enter the description.</div>
    </div>
    <div class="form-group">
      <label for="fileImage">Image:</label>
      <input type="file" class="form-control" id="fileImage" name="fileImage" required>
      <div class="invalid-feedback">Please select an image.</div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
         $('.alert-primary').hide();
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }else{
         event.preventDefault();
         event.stopPropagation();
         var formData = new FormData(this);
         sendNotification(formData);
        }  form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

function sendNotification(formData){
   $.ajax({
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      url: "index.php",
      success: function(resData) {
         $('.alert-primary').show();
      }
   });
}
</script>

</body>
</html>
