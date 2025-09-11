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
            <h1 class="m-0 text-dark">March Summary
      
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Month Summary</li>
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

  <!-- Main content -->
                  

  <section class="content">
        <form role="form" method="POST" action="">
            <?php

            $fromDate = "2022-02-01";
            $endDate = "2022-02-15";
                $r_m =date('M', strtotime($endDate));

            $sql="SELECT `status` FROM `company_reservation_month` where r_month ='$r_m'";
            $result = mysqli_query($con,$sql);
            if (mysqli_num_rows($result)==1) {
                $row=mysqli_fetch_assoc($result);

               if($row['status']  == "reservation"){

                $sql="select count(cr.r_date) as rt_date,rdc.room_conut_r7  from company_reservation cr,room_days_count rdc where  rdc.date_id = ".date('d', strtotime($endDate))." and cr.r_date <= '$endDate'";
                $result = mysqli_query($con,$sql);
                if (mysqli_num_rows($result)==1) {
                    $row=mysqli_fetch_assoc($result);
    
                    echo $row['rt_date'];
                    echo '<br>';
                    $c_r_tcount_room =($row['room_conut_r7']-$row['rt_date']);
                    echo $c_r_tcount_room;
                    echo '<br>';
                  
               }
               $sql="select sum(o_total_count) as o_total_count from revenues where date <= '$endDate'";
               $result = mysqli_query($con,$sql);
               if (mysqli_num_rows($result)==1) {
                   $row=mysqli_fetch_assoc($result);
                    $give_room_t=$row['o_total_count'];
                   echo $give_room_t;
               }
               echo '<br>';
               echo  round((($c_r_tcount_room/$give_room_t)*100),2);

            }else{
                echo "pass";
            }
  
            }
            // $sql="select r_date from company_reservation where r_date <= '$endDate'";
            // $result = mysqli_query($con,$sql);
            // if (mysqli_num_rows($result)==1) {
            //     $row=mysqli_fetch_assoc($result);
               
            // } 
            
        
            $sql='SELECT sum(r.o_total_amount) as o_total_amount, sum(r.o_total_count) as o_total_count, radt.amount_total_r7,rdc.room_conut_r7 FROM revenues r,room_amount_days_total radt ,room_days_count rdc  where radt.amount_date_id= '.date('d', strtotime($endDate)).' and date_id ='.date('d', strtotime($endDate)).'';
            // Date filter
            // if(isset($_POST['but_search'])){


            // $endDate = $_POST['endDate'];
            if(!empty($fromDate) && !empty($endDate)){
            $sql .= " and date 
                    between '".$fromDate."' and '".$endDate."' ";

                    $res=$con->query($sql);

                    while($row=$res->fetch_assoc()){   

            ?>
                <div class="card card-info"> 
                
                    <div class="card-body">
                            <!-- <div class="row">
                            
                                <div class="col-md-4">
                                    <div class="form-group"> 
                                        <input type="date" class="form-control"  id="endDate"  name='endDate'  value='< if(isset($_POST['endDate'])) echo $_POST['endDate']; ?>'>
                                        
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" id="endDate"  name='endDate'  value='<?php if(isset($_POST['endDate'])) echo $_POST['endDate']; ?>'/>
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group"> 
                                        <button  class="btn btn-block btn-primary"  name="but_search" >Filter</button>
                                    </div>
                                </div>
                            </div> -->
                        

                        

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Income</label> 
                                        <div class="input-group mb-3">
                                            <input type="number" name="o_total_amount" id="o_total_amount" value="<?php echo $row['o_total_amount']; ?>" class="form-control prc" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                    
                        <!-- /.card-body -->
                    </div>
                
                    <!-- /.container-fluid -->
                </div>

                <div class="card card-info"> 
                    <div class="card-body">
                
                            <div class="row">
                      
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Var %</label>
                                        <div class="input-group mb-3">
                                            <input type="number" name="R101s" value="<?php echo round(( $row['o_total_amount'] / $row['amount_total_r7'])*100,2) ?>" class="form-control prc" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>T.Rooms</label>
                                        <div class="input-group mb-3">
                                            <input type="number" name="R102s" class="form-control prc"  value="<?php echo $row['o_total_count'];  ?>" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Occ %</label>
                                        <div class="input-group mb-3">
                                            <input type="number" name="R103s" class="form-control prc" value="<?php echo round(( $row['o_total_count'] / $row['room_conut_r7'])*100,2);?>" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >Avg rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" name="R104s" class="form-control prc" value="<?php  echo round(($row['o_total_amount']/$row['o_total_count']),2); ?>" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        
                            <!-- /.card-body -->
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="add" id="add"  class="btn btn-primary">Submit</button>
                    </div>
                </div>
            <?php }}?>       
        </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->

  <?php


?>

<!--BLOCK#2 end YOUR CODE HERE -->

<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->