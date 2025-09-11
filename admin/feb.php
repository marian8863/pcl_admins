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
            <h1 class="m-0 text-dark">FEBRUARY Revenue</h1>
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- <div class="card-header">
                <h3 class="card-title">DataTable with minimal features & hover style</h3>
              </div> -->
              <!-- /.card-header -->

              <div class="card-body">
                <table id="example1"  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <!-- <th data-visible="false">Id</th> -->
                    <th>Date</th>
                    <th>101</th>
                    <th>102</th>
                    <th data-visible="false">103</th>
                    <th data-visible="false">104</th>
                    <th>105</th>
                    <th>107</th>
                    <th>108</th>
                    <th>109</th>
                    <th>110</th>
                    <th>T-Amount</th>
                    <th>T-Count</th>
                    <!-- <th data-visible="false">Create Date</th> -->
                  </tr>
                  </thead>
                  <tbody>
               
                  <?php           
                        $sql="SELECT * FROM revenues ORDER BY id desc ";
                        // Date filter
                        // if(isset($_POST['but_search'])){
                        //   $fromDate = $_POST['fromDate'];
                        //   $endDate = $_POST['endDate'];

                        //   if(!empty($fromDate) && !empty($endDate)){
                        //     $sql .= " and created_at 
                        //                   between '".$fromDate."' and '".$endDate."' ";
                        //   }
                        // }
                        $res=$con->query($sql);
                        while($row=$res->fetch_assoc()){       
                    ?>
                  <!-- data-toggle="collapse" data-target="#< $row['id']?>" -->
                    <tr>
                      <td><?= date('d M', strtotime($row['date']))?> </td>
                      <td> 
                        <!-- <a href="#" class="R101s" id="R101s_<$row["R101s"]?>" data-type="text" > -->
                          <?=$row["R101s"]?>
                        <!-- </a> -->
                      </td>
                      <td><?= $row['R102s']?></td>
                      <td><?= $row['R103s']?></td>
                      <td><?= $row['R104s']?></td>
                      <td><?= $row['R105s']?></td>
                      <td><?= $row['R107s']?></td>
                      <td><?= $row['R108s']?></td>
                      <td><?= $row['R109s']?></td>
                      <td><?= $row['R110s']?></td>
                      <td><?= $row['o_total_amount']?></td>
                      <td><?= $row['o_total_count']?></td>   
                    </tr>
                    <!-- <tr id="< $row['id']?>" class="collapse" >
                      <td colspan="7">
                        <div >< $row['name']?></div>
                      </td>
                    </tr> -->    
                    <?php } ?>

                  
                  </tbody>

                  <?php
                  
                  $sql = "select sum(o_total_amount)  as total,sum(o_total_count) as t_count from revenues";
                  $res=$con->query($sql);
                        while($row=$res->fetch_assoc()){   


                  
                  ?>
                  <tfoot>
                    <tr>
                      <th colspan="10"> </th>
                      <th> <?=$row['total'];?></th>
                      <th><?=$row['t_count'];?></th>
                      
                    </tr> 

                    <?php } ?>
                  </tfoot>
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
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->



<!--BLOCK#2 end YOUR CODE HERE -->


<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->