<!DOCTYPE html>
<html>
<head>
  <title>Auto Resize Textarea</title>
  <style>
    textarea {
      overflow: hidden;
      resize: none; /* Optional: prevents manual resizing */
    }
  </style>
</head>
<body>

<div class="form-group">
  <label>Adresse du pick-up</label>
  <textarea class="form-control" name="adresse_du_pick_up" rows="1" placeholder="Enter ..." required
            oninput="autoResize(this)">No 123 St Patrick's
07778705018</textarea>
</div>

<script>
function autoResize(textarea) {
  textarea.style.height = 'auto';          // Reset height
  textarea.style.height = textarea.scrollHeight + 'px'; // Set new height
}

// Optional: Trigger on page load if value already exists
document.addEventListener('DOMContentLoaded', function () {
  const ta = document.querySelector('textarea[name="adresse_du_pick_up"]');
  autoResize(ta);
});
</script>

</body>
</html>
