<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];

// $required_menu_name = 'view_users'; // ✅ MUST be defined before include
// echo "Checking menu: " . $required_menu_name;
//  include 'auth_check.php'; 

?>
<!--END DON'T CHANGE THE ORDER-->

<?php

if(isset($_GET['get_id'])){
    $user_id=$_GET['get_id'];
}
?>

<style>
  .profile-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile-thumb:hover {
    transform: scale(2); /* Enlarge 2x on hover */
    box-shadow: 0 4px 15px rgba(0,0,0,0.3); /* Optional shadow for depth */
    z-index: 10;
    position: relative;
}

</style>




<!--BLOCK#2 START YOUR CODE HERE -->
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users Detail</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item ">Users Detail
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
                    <a href="register" class="btn btn-primary btn-block"> + Add</a>

                </div>
                </div>
                <br>
                
                <table  id="example2"  class="table table-bordered">
    <thead>
        <tr>
            <th>Profile</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
            <td>
                <?php if (!empty($row['profile']) && file_exists('uploads/' . $row['profile'])): ?>
                    <img src="uploads/<?= $row['profile'] ?>" 
                         alt="Profile" 
                         class="profile-thumb clickable-img" 
                         data-bs-toggle="modal" 
                         data-bs-target="#profileModal" 
                         data-img="uploads/<?= $row['profile'] ?>">
                <?php else: ?>
                    <img src="uploads/default.png" 
                         alt="Default Profile" 
                         class="profile-thumb clickable-img" 
                         data-bs-toggle="modal" 
                         data-bs-target="#profileModal" 
                         data-img="uploads/default.png">
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td>
                <a href="edit_profile.php?id=<?= $row['id']; ?>" class="btn btn-info">
                    <i class="fas fa-users"></i>
                </a>
                <a href="edit_menu.php?user_id=<?= $row['id']; ?>" class="btn btn-info">
                    <i class="fas fa-edit"></i>
                </a>
                <button data-href="" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

  
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