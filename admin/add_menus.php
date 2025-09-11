<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];


$required_menu_name = 'add_menus'; // ✅ MUST be defined before include
// echo "Checking menu: " . $required_menu_name;
 include 'auth_check.php'; 
?>
<!--END DON'T CHANGE THE ORDER-->

<?php

$edit_id = '';
$menu_name = '';
$url = '';
$icon_class = '';
$parent_id = '';
$is_edit = false;

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $is_edit = true;

    // Fetch the existing menu data
    $stmt = $con->prepare("SELECT * FROM menus WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $menu_name = $row['menu_name'];
        $url = $row['url'];
        $icon_class = $row['icon_class'];
        $parent_id = $row['parent_id'];
    }

    $stmt->close();
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
            <h1 class="m-0 text-dark">Main Menu & Sub Menus ADD</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Settings and Privacy</a></li>
              <li class="breadcrumb-item ">Menus Adds
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
                    <a href="manage_menus" class="btn btn-primary btn-block"> Manage Menus</a>

                </div>
                </div>
                <br>
                
               <?php

// Handle update main menu
if (isset($_POST['update_main_menu'])) {
    $menu_id = $_POST['menu_id'];
    $menu_name = $_POST['menu_name'];
    $url = $_POST['url'];
    $icon_class = $_POST['icon_class'];

    $sql = "UPDATE menus SET menu_name='$menu_name', url='$url', icon_class='$icon_class' WHERE id='$menu_id'";
    if ($con->query($sql)) {
        $success_main_menu = "Main menu updated successfully!";
    } else {
        $error = "Error: " . $con->error;
    }
}

// Add new main menu
if (isset($_POST['add_main_menu'])) {
    $menu_name = $_POST['menu_name'];
    $url = $_POST['url'];
    $icon_class = $_POST['icon_class'];

    $sql = "INSERT INTO menus (menu_name, url, icon_class, parent_id, is_active) 
            VALUES ('$menu_name', '$url', '$icon_class', 'NULL', 1)";
    if ($con->query($sql)) {
        $success_main_menu = "Menu added successfully!";
    } else {
        $error = "Error: " . $con->error;
    }
}

// Add new sub menu
if (isset($_POST['add_sub_menu'])) {
    $menu_name = $_POST['menu_name'];
    $url = $_POST['url'];
    $icon_class = $_POST['icon_class'];
    $parent_id = $_POST['parent_id'];

    $sql = "INSERT INTO menus (menu_name, url, icon_class, parent_id, is_active) 
            VALUES ('$menu_name', '$url', '$icon_class', '$parent_id', 1)";
    if ($con->query($sql)) {
        $success_sub_menu = "Sub menu added successfully!";
    } else {
        $error = "Error: " . $con->error;
    }
}

// Fetch main menus for sub menu dropdown
$main_menus = $con->query("SELECT id, menu_name FROM menus WHERE parent_id ='NULL'");

// Get main menu data if ID is passed for editing
$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$edit_menu = null;
if ($edit_id > 0) {
    $result = $con->query("SELECT * FROM menus WHERE id = '$edit_id' AND parent_id ='NULL'");
    if ($result->num_rows > 0) {
        $edit_menu = $result->fetch_assoc();
    }
}
?>

<!-- MAIN MENU FORM -->
<h3><?= $edit_menu ? 'Edit Main Menu' : 'Add Main Menu' ?></h3>

<?php if (isset($success_main_menu)): ?>
    <div class="alert alert-success"><?= $success_main_menu ?></div>
<?php elseif (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" class="mb-4">
    <?php if ($edit_menu): ?>
        <input type="hidden" name="menu_id" value="<?= $edit_menu['id'] ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label>Menu Name</label>
        <input type="text" name="menu_name" class="form-control" required
               value="<?= $edit_menu ? htmlspecialchars($edit_menu['menu_name']) : '' ?>">
    </div>
    <div class="mb-3">
        <label>URL</label>
        <input type="text" name="url" class="form-control" required
               value="<?= $edit_menu ? htmlspecialchars($edit_menu['url']) : '' ?>">
    </div>
    <div class="mb-3">
        <label>Icon Class</label>
        <input type="text" name="icon_class" class="form-control" required
               value="<?= $edit_menu ? htmlspecialchars($edit_menu['icon_class']) : '' ?>">
    </div>
    <button type="submit" name="<?= $edit_menu ? 'update_main_menu' : 'add_main_menu' ?>"
            class="btn btn-primary">
        <?= $edit_menu ? 'Update Main Menu' : 'Add Main Menu' ?>
    </button>
</form>

<!-- SUB MENU FORM -->
<h3>Add Sub Menu</h3>

<?php if (isset($success_sub_menu)): ?>
    <div class="alert alert-success"><?= $success_sub_menu ?></div>
<?php elseif (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label>Select Main Menu</label>
        <select name="parent_id" class="form-select" required>
            <option value="">-- Choose Main Menu --</option>
            <?php while ($row = $main_menus->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" <?= ($edit_id == $row['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['menu_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Sub Menu Name</label>
        <input type="text" name="menu_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Sub Menu URL</label>
        <input type="text" name="url" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Sub Menu Icon Class</label>
        <input type="text" name="icon_class" class="form-control" required>
    </div>
    <button type="submit" name="add_sub_menu" class="btn btn-success">Add Sub Menu</button>
</form>




  
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