<style>

</style>
<?php
// $u_n = $_SESSION['user_name'];
// $u_ta = $_SESSION['user_table'];
// $u_t = $_SESSION['user_type'];
// $d_c = $_SESSION['department_code'];

$u_id = $_SESSION['user']['id'];
echo $u_id;
$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];

// $username = null;
// if($u_ta=='staff'){
//   $sql = "SELECT * FROM `staff` WHERE `staff_id` = '$u_n'";
//   $result = mysqli_query($con, $sql);
//   if (mysqli_num_rows($result) == 1) {
//   $row = mysqli_fetch_assoc($result);
//   $username =  $row['staff_name'];
//   }

// }if($u_ta=='student'){
//   $sql = "SELECT * FROM `student` WHERE `student_id` = '$u_n'";
//   $result = mysqli_query($con, $sql);
//   if (mysqli_num_rows($result) == 1) {
//   $row = mysqli_fetch_assoc($result);
//   $username =  $row['student_fullname'];
//   }
// }

?>

<?php


// Get user_type from query string (default = all)
$filter_type = isset($_GET['type']) ? $_GET['type'] : '';
$filter_map = [
    'admin'   => 'admin',
    'adm'     => 'ADM',
    'users'   => 'user_enties',
    'drivers' => 'driver'
];

// Build SQL
$sql = "SELECT `id`, `username`, `email`, `phone`, `user_type`, `profile` ,`user_desc`FROM users";

if ($filter_type && isset($filter_map[$filter_type])) {
    $user_type = $filter_map[$filter_type];
    $sql .= " WHERE user_type='$user_type'";
}

$res = $con->query($sql);
?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" fixed>
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a> 
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <?php if ($_SESSION['user']['user_type'] == 'admin') {?>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
<?php }?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user-lock"></i>
          <!-- <span class="badge badge-danger navbar-badge">3</span> -->
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
         
            <!-- Message Start -->
            <div class="media dropdown-item">
              <img src="uploads/<?php echo $u_p; ?>" class="img-size-50 mr-3 img-circle" alt="User Image">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <?php echo $u_n; ?>
                  <span class="float-right text-sm text-success"><i class="fas fa-signal"></i></span>
                </h3>
                <p class="text-sm"><?php echo $u_t; ?></p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Member since July. 2023</p>
              </div>
            </div>
            <!-- Message End -->
        
       
          <div class="dropdown-divider"></div>
          <a  href="../login.php?logout='1'"  class="dropdown-item dropdown-footer">Sign out</a>
        </div>
      </li>
      <?php if ($_SESSION['user']['user_type'] == 'admin') {?>

      <li class="nav-item dropdown">
      <a class="nav-link" tatget="_blank" href="change-password.php">
        <i class="fas fa-user-lock"></i>
      </a>
      </li>
      <?php }?>


              <!--user count start-->
            <?php
            $sql = "SELECT COUNT(id) AS users_totlal FROM `users`";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    $ut = $row["users_totlal"];

                }
            } else {
                echo "0 results";
            }
            ?>
            <!--user count end-->
            <!--adminin  count start-->  
            <?php
            $sql = "SELECT COUNT(id) AS users_adminin_totlal FROM `users` Where user_type='admin'";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    $u_a_t = $row["users_adminin_totlal"];

                }
            } else {
                echo "0 results";
            }
            ?>
            <!--adminin  count end-->  
            <!--user   count start-->  
            <?php
            $sql = "SELECT COUNT(id) AS users_user_totlal FROM `users` Where user_type='user_enties'";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    $u_u_t = $row["users_user_totlal"];

                }
            } else {
                echo "0 results";
            }
            ?>

                        <!--ADM   count start-->  
            <?php
            $sql = "SELECT COUNT(id) AS users_ADM_totlal FROM `users` Where user_type='ADM'";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    $u_M_t = $row["users_ADM_totlal"];

                }
            } else {
                echo "0 results";
            }
            ?>

                                    <!--driver   count start-->  
            <?php
            $sql = "SELECT COUNT(id) AS users_Driver_totlal FROM `users` Where user_type='driver'";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    $u_D_t = $row["users_Driver_totlal"];

                }
            } else {
                echo "0 results";
            }
            ?>

                                               <!--Enteries   count start-->  
            <?php
            $sql = "SELECT COUNT(id) AS users_Enteries_totlal FROM `users` Where user_type='enteries'";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    $u_E_t = $row["users_Enteries_totlal"];

                }
            } else {
                echo "0 results";
            }
            ?>
            <!--user   count end--> 

       <!-- new user -->
     <?php if ($_SESSION['user']['user_type'] == 'admin' || $_SESSION['user']['user_type'] == 'ADM') {?>        
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-users"></i>
          <span class="badge badge-warning navbar-badge"><?php echo $ut; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">You have <?php echo $ut; ?> assest </span>
         
        <?php if ($_SESSION['user']['user_type'] == 'admin' ) {?> 
          <div class="dropdown-divider"></div>
        <a href="view_authorizers?type=admin" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Admin
            <span class="float-right text-muted text-sm"><?php echo $u_a_t ?></span>
        </a>
        <?php }?>
     
        <div class="dropdown-divider"></div>
        <a href="view_authorizers?type=adm" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> ADM
            <span class="float-right text-muted text-sm"><?php echo $u_M_t ?></span>
        </a>

        <div class="dropdown-divider"></div>
        <a href="view_authorizers?type=users" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Users
            <span class="float-right text-muted text-sm"><?php echo $u_u_t ?></span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="view_authorizers?type=drivers" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Drivers
            <span class="float-right text-muted text-sm"><?php echo $u_D_t ?></span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="view_authorizers?type=enteries" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Enteries
            <span class="float-right text-muted text-sm"><?php echo $u_E_t ?></span>
        </a>


          <div class="dropdown-divider"></div>
          <a href="register" class="dropdown-item dropdown-footer">Create another account</a>
          <!-- <div class="dropdown-divider"></div>
          <a href="view_users" class="dropdown-item dropdown-footer">View Users</a> -->
        </div>
      </li>
      <?php }?>
      
      
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link">
      <img src="dist/img/logo_pdf.jpg" alt="admininLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"> Paris Cab Limousinee </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="uploads/<?php echo $u_p; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $u_n; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <?php




// Get all submenus the user has access to
$sqlAllowedSubmenus = "SELECT menu_id FROM user_menu_access WHERE user_id = ?";
$stmtAllowed = $con->prepare($sqlAllowedSubmenus);
$stmtAllowed->bind_param("i", $u_id);
$stmtAllowed->execute();
$resultAllowed = $stmtAllowed->get_result();

$allowedMenuIds = [];
while ($row = $resultAllowed->fetch_assoc()) {
    $allowedMenuIds[] = $row['menu_id'];
}

// Fetch all main menus
$sqlMain = "SELECT * FROM menus WHERE parent_id = 'NULL' AND is_active = 1 ORDER BY id";
$resultMain = $con->query($sqlMain);

echo '<nav class="mt-2">';
echo '<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';

while ($main = $resultMain->fetch_assoc()) {
    $main_id = $main['id'];

    // Fetch submenus under this main menu that the user is allowed to see
    $sqlSub = "SELECT * FROM menus WHERE parent_id = ? AND is_active = 1 ORDER BY id";
    $stmtSub = $con->prepare($sqlSub);
    $stmtSub->bind_param("i", $main_id);
    $stmtSub->execute();
    $subMenus = $stmtSub->get_result();

    $visibleSubmenus = [];

    while ($sub = $subMenus->fetch_assoc()) {
        if (in_array($sub['id'], $allowedMenuIds)) {
            $visibleSubmenus[] = $sub;
        }
    }

    // Only show main menu if there are visible submenus
    if (!empty($visibleSubmenus)) {
        echo '<li class="nav-item has-treeview menu-open">';
        echo '<a href="#" class="nav-link active">';
        echo '<i class="nav-icon ' . htmlspecialchars($main['icon_class']) . '"></i>';
        echo '<p>' . htmlspecialchars($main['menu_name']) . '<i class="right fas fa-angle-left"></i></p>';
        echo '</a>';
        echo '<ul class="nav nav-treeview">';
        foreach ($visibleSubmenus as $sub) {
            echo '<li class="nav-item">';
            echo '<a href="' . htmlspecialchars($sub['url']) . '" class="nav-link">';
            echo '<i class="' . htmlspecialchars($sub['icon_class']) . ' nav-icon"></i>';
            echo '<p>' . htmlspecialchars($sub['menu_name']) . '</p>';
            echo '</a>';
            echo '</li>';
        }
        echo '</ul>';
        echo '</li>';
    }
}

echo '</ul>';
echo '</nav>';
?>


      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>







