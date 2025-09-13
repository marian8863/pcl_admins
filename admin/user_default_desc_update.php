<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];

$required_menu_name = 'user_default_desc_update'; // ✅ MUST be defined before include
// echo "Checking menu: " . $required_menu_name;
 include 'auth_check.php'; 




// Force UTF-8 for the connection (important for accents!)
mysqli_set_charset($con, "utf8mb4");

$message = "";

// Get current default value for user_desc
$col_res = mysqli_query($con, "SHOW CREATE TABLE users");
$col_info = mysqli_fetch_assoc($col_res);
$current_default = $col_info['Default'] ?? ''; // current default

// Handle update request
if (isset($_POST['update_default'])) {
    $new_default = $_POST['new_default'] ?? '';
    
    if ($new_default !== '') {
        // Escape safely for SQL
        $escaped_default = mysqli_real_escape_string($con, $new_default);

        // Update the column default in MySQL
        $sql = "ALTER TABLE users 
                ALTER COLUMN user_desc SET DEFAULT '" . $escaped_default . "'";

        if (mysqli_query($con, $sql)) {
            $message = "✅ Default value updated successfully to <b>" . htmlspecialchars($new_default) . "</b>!";
            $current_default = $new_default; // update displayed default
        } else {
            $message = "❌ Error: " . mysqli_error($con);
        }
    } else {
        $message = "⚠️ Please enter a new default value.";
    }
}
?>
<!--END DON'T CHANGE THE ORDER-->




<!--BLOCK#2 START YOUR CODE HERE -->
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Users Default Description</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">All Users Default Description
              <?php
                  // echo  $Sdate = new DateTime("now", new DateTimeZone('Asia/Colombo'));
                //   date_default_timezone_set('Asia/Colombo');
                //   $date = date('d-m-y h:i:s');
                //   echo $date;
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">verification</h3>
            </div>
                <!-- /.card-header -->
                <div class="card-body">

<div class="container">
    <div class="card shadow rounded-3">
        <div class="card-body">
            <h3 class="card-title mb-3">Update Default Value for <code>user_desc</code></h3>

            <?php if (!empty($message)): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Current Default Value (from DB)</label>
                    <textarea class="form-control" rows="4" readonly><?= htmlspecialchars($current_default) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">New Default Value</label>
                    <textarea class="form-control" name="new_default" rows="4" placeholder="Enter new default value"><?= htmlspecialchars($_POST['new_default'] ?? '') ?></textarea>
                </div>

                <button type="submit" name="update_default" class="btn btn-primary">
                    Update Default Value
                </button>
            </form>
        </div>
    </div>
</div>
                </div>

            <!-- /.card-body -->

        </div>
      <!-- /.card -->
    </section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->



<!--BLOCK#2 end YOUR CODE HERE -->
<?php

if (isset($_POST['add'])) {
    if (!empty($_POST['Create_job_action'])) {

        $Create_job_action = $_POST['Create_job_action'];

        $sql = "UPDATE `passenger` 
                   SET `Create_job_action` = ? 
                 WHERE `p_id` = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $Create_job_action, $pid);

        if ($stmt->execute()) {

            // ✅ If action is 'completed' → delete related history
            if ($Create_job_action === 'completed') {
                $del_sql = "DELETE FROM ride_status_history WHERE p_id = ?";
                $del_stmt = $con->prepare($del_sql);
                $del_stmt->bind_param("i", $pid);
                if ($del_stmt->execute()) {
                    // history deleted successfully (optional logging)
                } else {
                    echo "Error deleting record: " . $con->error;
                }
                $del_stmt->close();
            }

            // ✅ Show SweetAlert based on action
            if ($Create_job_action === 'created') {
                $redirect_url = "view_passenger";
            } elseif ($Create_job_action === 'completed') {
                $redirect_url = "view_passenger_action_completed";
            } elseif ($Create_job_action === 'cancel') {
                $redirect_url = "view_passenger_action_cancel";
            }

            echo '<script>
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Your Job has been ' . $Create_job_action . '",
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = "' . $redirect_url . '";
                });
            </script>';

        } else {
            echo "Error :- " . $sql . "<br>" . mysqli_error($con);
        }

        $stmt->close();
    }
}
?>

<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->