<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];

?>
<!--END DON'T CHANGE THE ORDER-->

<?php

if(isset($_GET['get_id'])){
    $plid=$_GET['get_id'];
    $sql="SELECT `name` from flight_locations where id='$plid'";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)==1) {       
        $row=mysqli_fetch_assoc($result);
        $pln=$row['name'];
    }
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
            <h1 class="m-0 text-dark">Passenger Locations</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Passenger Locations
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
                <?php
                if(isset($_GET['get_id'])){
                ?>
                    <h3 class="card-title">Edit Passenger Locations</h3>
                <?php
                }else{
                ?>
                    <h3 class="card-title">Create Passenger Locations</h3>
                <?php
                }
                ?>
            </div>
                <!-- /.card-header -->
                <div class="card-body">
                <form method="POST">
                 <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Passenger Locations </label>
                        <input type="text" class="form-control" name="name" value="<?php if(isset($_GET['get_id'])){ echo $pln;}?>" placeholder="Enter ...">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                      <?php
                        if(isset($_GET['get_id'])){
                        ?>
                        <input type="submit" class="btn btn-danger btn-block" value="- Edit Passenger Locations" name="edit"> 
                        <?php
                        }else{
                        ?>
                        <input type="submit" class="btn btn-primary btn-block" value="+ Add Passenger Locations" name="add"> 
                        <?php
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </form>
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
if(isset($_POST['add'])){

    if(!empty($_POST['name'])){
        $name=$_POST['name'];
  
        $sql="INSERT INTO `flight_locations` (`name`) values('$name')";
        if(mysqli_query($con,$sql)){
            //$message ="<h5>New record created successfully</h5>";
          echo '<script>';
          echo '
          Swal.fire({
             position: "top-end",
         
             icon: "success",
             title: "Your Passenger Locations has been saved",
             showConfirmButton: false,
            
             timer: 1500
           }).then(function() {
             // Redirect the user
             window.location.href = "passenger_locations";
         
             });
          ';
          echo '</script>';  
        }else{
            echo "Error :-".$sql.
          "<br>"  .mysqli_error($con);
        }
    }
}
?>


<?php
if(isset($_POST['edit'])){
    if(!empty($_POST['name'])){
        $name=$_POST['name'];

  $sql='UPDATE  `flight_locations`
  set `name` ="'.$name.'"

  where `id`="'.$plid.'"';
  if(mysqli_query($con,$sql)){
   
    // $message ="<h4 class='text-success' >Update successfully</h4>";
    echo '<script>';
    echo '
    Swal.fire({
       position: "top-end",
   
       icon: "success",
       title: "Your Passenger Locations has been updated",
       showConfirmButton: false,
      
       timer: 1500
     }).then(function() {
       // Redirect the user
       window.location.href = "passenger_locations";
   
       });
    ';
    echo '</script>';
}else{
    echo "Error :-".$sql.
  "<br>"  .mysqli_error($con);
}
}
}
?>
<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->