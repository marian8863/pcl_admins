<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];



// // Only admin allowed
if ($_SESSION['user']['user_type'] == 'admin' || $_SESSION['user']['user_type'] == 'ADM') {
    


// if (!isset($_GET['id'])) {
//     die("No user ID provided");
// }

$user_id = intval($_GET['id']);
$result = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found");
}

?>
<!--END DON'T CHANGE THE ORDER-->
<?php


?>




  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Authorizers Edit Profiles</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item ">Authorizers Detail
              <?php
                  // echo  $Sdate = new DateTime("now", new DateTimeZone('Asia/Colombo'));
                  // date_default_timezone_set('UTC');

                  // // Get the current date and time
                  // $currentDateTime = date('Y-m-d H:i:s');
                  
                  // // Display the current date and time
                  // echo "Current Date and Time: " . $currentDateTime;
              ?>
              </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <!-- Main content -->


  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">

<form method="post" action="update_user" enctype="multipart/form-data" class="p-4">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

            <!-- Profile Picture -->
            <div class="text-center mb-4">
              <img id="profilePreview" 
                   src="uploads/<?php echo $user['profile'] ?: 'default.png'; ?>" 
                   alt="Profile Picture" 
                   class="rounded-circle shadow" 
                   style="width:120px; height:120px; object-fit:cover;">
              <div class="mt-2">
                <label class="btn btn-outline-secondary btn-sm mb-0">
                  <i class="fas fa-upload"></i> Change Photo
                  <input type="file" name="profile" id="profile" accept="image/*" hidden 
                         onchange="previewImage(event)">
                </label>
              </div>
            </div>

            <!-- Username -->
            <div class="form-group mb-3">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" name="username" 
                     value="<?php echo $user['username']; ?>" required>
            </div>

            <!-- Email -->
            <div class="form-group mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email" 
                     value="<?php echo $user['email']; ?>" required>
            </div>



            <!-- User Type -->
            <div class="form-group mb-3">
              <label class="form-label">User Type</label>
              <select class="form-control" name="user_type" required>
                <option value="admin"  <?php if ($user['user_type'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="ADM"    <?php if ($user['user_type'] == 'ADM') echo 'selected'; ?>>ADM</option>
                <option value="user"   <?php if ($user['user_type'] == 'user_enties') echo 'selected'; ?>>User</option>
                <option value="driver" <?php if ($user['user_type'] == 'driver') echo 'selected'; ?>>Driver</option>
              </select>
            </div>

                        <!-- Authorizers Desc -->
            <div class="form-group mb-3">
              <label class="form-label">Authorizers Description</label>
              <textarea  class="form-control" id="user_desc" name="user_desc" 
                     required><?php echo $user['user_desc']; ?></textarea>
            </div>

            <!-- Phone -->
            <div class="form-group mb-3">
              <label class="form-label">Phone</label>
              <input type="tel" class="form-control" id="phone" name="phone" 
                     value="<?php echo $user['phone']; ?>" required>
            </div>

            <!-- Current Password -->
            <div class="form-group mb-3">
              <label class="form-label">Current Password (hashed)</label>
              <input type="text" class="form-control" 
                     value="<?php echo $user['password']; ?>" readonly>
            </div>

            <!-- Change Password Checkbox -->
            <div class="form-check mb-3">
              <input type="checkbox" class="form-check-input" id="change_pass" onchange="togglePassword()">
              <label for="change_pass" class="form-check-label">Change Password</label>
            </div>

            <!-- New Password -->
            <div id="new_pass_div" class="form-group mb-3" style="display:none;">
              <label class="form-label">New Password</label>
              <input type="password" class="form-control" name="new_password">
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end">
              <button type="submit" name="update_user" class="btn btn-success px-4">
                <i class="fas fa-save"></i> Update User
              </button>
            </div>
          </form>
  

<!-- Intl Tel Input -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

<script>
  const phoneInput = document.querySelector("#phone");
  const iti = window.intlTelInput(phoneInput, {
    initialCountry: "us",
    nationalMode: false,
    formatOnDisplay: true
  });

  document.querySelector("form").addEventListener("submit", function () {
    phoneInput.value = iti.getNumber();
  });

  function togglePassword() {
    const check = document.getElementById("change_pass");
    const div = document.getElementById("new_pass_div");
    div.style.display = check.checked ? "block" : "none";
  }
</script>

<script>
  function togglePassword() {
    document.getElementById("new_pass_div").style.display = 
      document.getElementById("change_pass").checked ? "block" : "none";
  }

  function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
      document.getElementById('profilePreview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>



</div>
</div>
</div>
</div>
</section>
<?php }?>

<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->