<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];

$user_id = $_GET['user_id'] ;

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
            <h1 class="m-0 text-dark">Menus Authentication</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item ">Menus Authentication
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
              


            <?php




// Fetch all menus
$menus = [];
$menu_q = $con->query("SELECT * FROM menus WHERE is_active = 1 ORDER BY parent_id, id");
while ($row = $menu_q->fetch_assoc()) {
    $menus[] = $row;
}

// Fetch user access
$access_q = $con->query("SELECT menu_id FROM user_menu_access WHERE user_id = $user_id");
$user_access = [];
while ($row = $access_q->fetch_assoc()) {
    $user_access[] = $row['menu_id'];
}
?>
<!-- Include Bootstrap 5 CDN (only once in your layout) -->
<form method="post" action="update_user_access">
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">

    <?php
    $header_shown = false; // flag to control single header

    // Group menus by parent
    $parents = array_filter($menus, function($m) {
        return $m['parent_id'] == 0;
    });

    foreach ($parents as $parent) {
        echo "<table class='table table-bordered' style='margin-bottom: 20px;'>
                <thead class='table-light'>
                    <tr>
                        <th colspan='2'>{$parent['menu_name']}</th>
                    </tr>";

        // Show header row only once
        if (!$header_shown) {
            echo "<tr>
                    <th>Menu Name</th>
                    <th>Access</th>
                  </tr>";
            $header_shown = true;
        }

        echo "</thead><tbody>";

        foreach ($menus as $menu) {
            if ($menu['parent_id'] == $parent['id']) {
                $checked = in_array($menu['id'], $user_access) ? 'checked' : '';
                echo "<tr>
                        <td>{$menu['menu_name']}</td>
                        <td>
                            <div class='form-check form-switch'>
                                <input class='form-check-input' type='checkbox' name='menus[]' data-bootstrap-switch data-off-color='danger' data-on-color='success' value='{$menu['id']}' $checked>
                            </div>
                        </td>
                      </tr>";
            }
        }

        echo "</tbody></table>";
    }
    ?>

    <button type="submit" class="btn btn-primary">Update Access</button>
</form>


                                <!-- <input class='form-check-input' type='checkbox' name='menus[]' value='{$menu['id']}' $checked> -->



</div>
</div>
</div>
</div>
</section>


<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->