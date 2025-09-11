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
    $uid=$_GET['get_id'];
    $sql="SELECT username,phone,user_desc from users where id='$uid'";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)==1) {       
        $row=mysqli_fetch_assoc($result);
        $dn=$row['username'];
        $dtp=$row['phone'];
        $user_desc=$row['user_desc'];
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
            <h1 class="m-0 text-dark">Drivers Detail</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">February
              <?php
                  // echo  $Sdate = new DateTime("now", new DateTimeZone('Asia/Colombo'));
                  date_default_timezone_set('Asia/Colombo');
                  $date = date('d-m-y h:i:s');
                  echo $date;
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
                    <h3 class="card-title">Edit Drivers</h3>
                <?php
                }else{
                ?>
                    <h3 class="card-title">Create Drivers</h3>
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
                        <label>Chauffeur</label>
                        <input type="text" class="form-control" name="dname" value="<?php if(isset($_GET['get_id'])){ echo $dn;}?>" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Chauffeur Contact Number</label>
                        <!-- <input type="text" class="form-control" name="dtp_num" value="<php if(isset($_GET['get_id'])){ echo $dtp;}?>" placeholder="Enter ..."> -->
<input 
  type="tel" 
  class="form-control" 
  name="dtp_num" 
  id="dtp_num" 
  placeholder="+94 71 234 5678" 
  value="<?php if(isset($_GET['get_id'])){ echo $dtp;}?>" 
  required>



                      </div>
                    </div>

                    <div class="col-sm-12">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Driver Desc</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="user_desc" required><?php if(isset($_GET['get_id'])){ echo $driver_desc;}else{echo "
                          Le règlement s'effectuera dans un délai de 10 jours suivant la réception de la facture. Les missions effectuées pendant le mois doivent être facturées à la fin du mois en cours. La référence de bon de mission est obligatoire. La facture doit être envoyée à cette adresse mail : pclfacture@gmail.com 
                          ";}?></textarea>
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
                        <input type="submit" class="btn btn-danger btn-block" value="- Edit Driver" name="edit"> 
                        <?php
                        }else{
                        ?>
                        <input type="submit" class="btn btn-primary btn-block" value="+ Add Driver" name="add"> 
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

    if(!empty($_POST['username'])&& 
    !empty($_POST['phone'])){
        $username=$_POST['username'];
        $phone=$_POST['phone'];
        $user_desc=$_POST['user_desc'];
        
  
        $sql='INSERT INTO `users` (`username`,`dtp_num`,`driver_desc`) values("'.$dname.'","'.$dtp_num.'","'.$driver_desc.'")';
        if(mysqli_query($con,$sql)){
            //$message ="<h5>New record created successfully</h5>";
          echo '<script>';
          echo '
          Swal.fire({
             position: "top-end",
         
             icon: "success",
             title: "Your Driver has been saved",
             showConfirmButton: false,
            
             timer: 1500
           }).then(function() {
             // Redirect the user
             window.location.href = "view_drivers";
         
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
    if(!empty($_POST['dname'])&& 
    !empty($_POST['dtp_num'])){
    $d_id=$_GET['get_id'];
    $dname=$_POST['dname'];
    $dtp_num=$_POST['dtp_num'];
    $driver_desc=$_POST['driver_desc'];
    

  $sql='UPDATE  `driver`
  set `dname` ="'.$dname.'",
  `dtp_num`="'.$dtp_num.'",
  `driver_desc`="'.$driver_desc.'"

  where `d_id`="'.$did.'"';
  if(mysqli_query($con,$sql)){
   
    // $message ="<h4 class='text-success' >Update successfully</h4>";
    echo '<script>';
    echo '
    Swal.fire({
       position: "top-end",
   
       icon: "success",
       title: "Your Driver has been updated",
       showConfirmButton: false,
      
       timer: 1500
     }).then(function() {
       // Redirect the user
       window.location.href = "view_drivers";
   
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