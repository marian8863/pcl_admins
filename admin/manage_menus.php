<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];


$required_menu_name = 'manage_menus'; // ✅ MUST be defined before include
// echo "Checking menu: " . $required_menu_name;
 include 'auth_check.php'; 
?>
<!--END DON'T CHANGE THE ORDER-->

<?php

if(isset($_GET['get_id'])){
    $did=$_GET['get_id'];
}
?>



<!--BLOCK#2 START YOUR CODE HERE -->
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Menus</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Settings and Privacy</a></li>
              <li class="breadcrumb-item ">Manage Menus
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
              <!-- <div class="card-header">
                <h3 class="card-title">DataTable with minimal features & hover style</h3>
              </div> -->
              <!-- /.card-header -->

              <div class="card-body">
              <div class="row">
                <div class="col-9">
                </div>
                <!-- /.col -->
                <div class="col-3">
                    <a href="add_menus" class="btn btn-primary btn-block"> manage Menus</a>

                </div>
                </div>
                <br>
                
<?php

// DELETE
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $con->query("DELETE FROM menus WHERE id = $id");
    header("Location: manage_menus.php");
    exit();
}

// TOGGLE is_active
if (isset($_POST['toggle_id']) && isset($_POST['is_active'])) {
    $id = $_POST['toggle_id'];
    $is_active = $_POST['is_active'];
    $con->query("UPDATE menus SET is_active = $is_active WHERE id = $id");
    echo 'updated';
    exit();
}

// Get all menus with parent/sub relationship
$menus = $con->query("SELECT * FROM menus ORDER BY COALESCE(parent_id, id), parent_id IS NOT NULL, id");
?>


    <title>Manage Menus</title>
    <style>
        .submenu { padding-left: 40px; background: #f8f9fa; }
    </style>


<h3>Menu Management</h3>
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Menu Name</th>
            <th>URL</th>
            <th>Parent</th>
            <th>Icon</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $menus->fetch_assoc()): ?>
        <tr class="<?= $row['parent_id'] ? 'submenu' : '' ?>">
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['menu_name']) ?></td>
            <td><?= htmlspecialchars($row['url']) ?></td>
            <td><?= $row['parent_id'] ? $row['parent_id'] : 'Main Menu' ?></td>
            <td><i class="<?= htmlspecialchars($row['icon_class']) ?>"></i></td>
            <td>
                <input type="checkbox" class="form-check-input toggle-status" 
                    data-id="<?= $row['id'] ?>" <?= $row['is_active'] ? 'checked' : '' ?>>
            </td>
            <td>
                <a href="add_menus.php?edit_id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="manage_menus.php?delete_id=<?= $row['id'] ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Delete this menu?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<script>
document.querySelectorAll('.toggle-status').forEach(function(toggle) {
    toggle.addEventListener('change', function() {
        const id = this.getAttribute('data-id');
        const isActive = this.checked ? 1 : 0;

        fetch('manage_menus.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'toggle_id=' + id + '&is_active=' + isActive
        });
    });
});
</script>








  
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

        
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->

	<!-- END DELETE MODEL -->

<!--BLOCK#2 end YOUR CODE HERE -->


<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->