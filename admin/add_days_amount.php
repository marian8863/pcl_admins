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




<!--BLOCK#2 START YOUR CODE HERE -->
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Days Amount
            
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Days Amount</li>
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <!-- Main content -->
                  

  <section class="content">
        <form role="form" method="POST" action="">
            <div class="card card-info"> 
            
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date:</label>
                                <!-- <div class="input-group date" id="date" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#date" name="date"/>
                                    <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>      -->
                                <input type="date" class="form-control" name="date" id="txtDate2" required>

                            </div>
                        </div>
                    </div>
                





                    <div class="row">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>R.101</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="R101s" class="form-control prc" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>R.102</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="R102s" class="form-control prc" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>R.103</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="R103s" class="form-control prc" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >R.104</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="R104s" class="form-control prc" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >R.105</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="R105s" class="form-control prc" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >R.107</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="R107s" class="form-control prc" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >R.108</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="R108s" class="form-control prc" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>                   
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>R.109</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="R109s" class="form-control prc" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>R.110</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="R110s" class="form-control prc" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Amount</label>
                                <div class="input-group mb-3">
                                <input type="number" name="o_total_amount"  id="o_total_amount" class="form-control " readonly>
                                <output id="o_total_amount"></output>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Total Room</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="o_total_count" class="form-control " required>                                    
                                </div>
                            </div>
                        </div>
                    </div>    
                    <!-- /input-group -->  
                </div>
                <div class="card-footer">
                  <button type="submit" name="add" id="add"  class="btn btn-primary">Submit</button>
                </div>
         
              <!-- /.card-body -->
            </div>
            <!-- /.container-fluid -->
        </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->

  <?php
if(isset($_POST['add'])){

  if(!empty($_POST['date'])&& 
   !empty($_POST['R101s'])&& 
   !empty($_POST['R102s'])&&
   !empty($_POST['R103s'])&& 
   !empty($_POST['R104s'])&& 
   !empty($_POST['R105s'])&& 
   !empty($_POST['R107s'])&& 
   !empty($_POST['R108s'])&& 
   !empty($_POST['R109s'])&& 
   !empty($_POST['R110s'])&& 
   !empty($_POST['o_total_amount'])&&
   !empty($_POST['o_total_count'])){
      $date=$_POST['date'];
      $R101s=$_POST['R101s'];
      $R102s=$_POST['R102s'];
      $R103s=$_POST['R103s'];
      $R104s=$_POST['R104s'];
      $R105s=$_POST['R105s'];
      $R107s=$_POST['R107s'];
      $R108s=$_POST['R108s'];
      $R109s=$_POST['R109s'];
      $R110s=$_POST['R110s'];
      $o_total_amount=$_POST['o_total_amount'];
      $o_total_count=$_POST['o_total_count'];

   
    //   $s_date = new DateTime("now", new DateTimeZone('Asia/Colombo') );
    date_default_timezone_set('Asia/Colombo');
    $s_date = date('d-m-y h:i:s');
    echo $s_date;

      $sql='INSERT INTO `revenues` (`date`,`R101s`,`R102s`,`R103s`,`R104s`,`R105s`,`R107s`,`R108s`,`R109s`,`R110s`,`o_total_amount`,`o_total_count`,`create_date`) values("'.$date.'","'.$R101s.'","'.$R102s.'","'.$R103s.'","'.$R104s.'","'.$R105s.'","'.$R107s.'","'.$R108s.'","'.$R109s.'","'.$R110s.'","'.$o_total_amount.'","'.$o_total_count.'","'.$s_date.'")';
      if(mysqli_query($con,$sql)){
        //   $message ="<h4 class='text-success' >New record created successfully</h4>";
          echo '<script>';
          echo '
          Swal.fire({
             position: "top-end",
         
             icon: "success",
             title: "Add Today Amonut",
             showConfirmButton: false,
            
             timer: 1500
           }).then(function() {
             // Redirect the user
             window.location.href = "feb";
         
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

<!--BLOCK#2 end YOUR CODE HERE -->

<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->