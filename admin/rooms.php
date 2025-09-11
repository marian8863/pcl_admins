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
                            <form>
                              <div class="row">
                                <div class="col-sm-3">
                                  <!-- text input -->
                                  <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label"  data-radio="radio_1">
                                          <input class="form-check-input" type="radio"name="lang" class="input"  checked>
                                          Check-in
                                        </label>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <div class="form-check">
                                      <label class="form-check-label"  data-radio="radio_2">
                                        <input class="form-check-input" type="radio"name="lang" class="input" >
                                        No-Show
                                      </label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </form>

                            <!-- hide text -->
                            <div class="content">
                              <div class="form-group radio_content radio_1">
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                              </div>
                              <div class=" form-group radio_content radio_2">
                                <select class="form-control">
                                  <option>option 1</option>
                                  <option>option 2</option>
                                  <option>option 3</option>
                                  <option>option 4</option>
                                  <option>option 5</option>
                                </select>
                              </div>
	
	                          </div>
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

<script>
  		$(document).ready(function(){
			/* by default hide all radio_content div elements except first element */
			$(".content .radio_content").hide();
			$(".content .radio_content:first-child").show();

			/* when any radio element is clicked, Get the attribute value of that clicked radio element and show the radio_content div element which matches the attribute value and hide the remaining tab content div elements */
			$(".form-check-label").click(function(){
			  var current_raido = $(this).attr("data-radio");
			  $(".content .radio_content").hide();
			  $("."+current_raido).show();
			})
		});
</script>
<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->