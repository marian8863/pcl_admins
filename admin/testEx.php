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
$tdm=null;
if(isset($_GET['get_id'])){
  $pid=$_GET['get_id'];
  $sql="SELECT passenger.d_id,passenger.tm_id, select_an_option_desc.tm_desc
  
  
  from passenger ,select_an_option_desc
  
  WHERE passenger.p_id=select_an_option_desc.p_id and
  passenger.p_id=$pid";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)==1) {       
        $row=mysqli_fetch_assoc($result);

        $dn=$row['d_id'];
  
        $tdm=$row['tm_id'];
      
        $Dispo_Hours=$row['tm_desc'];
    }

}

?>
<div class="content-wrapper">
                
                    <div class="col-sm-6">
                      <label for="selection">Select an option:</label>
                      <select class="form-control custom-select" style="width: 100%;" onchange="showSelectOption(this.value)" name="tm_id" >
                          <option value="null" selected disabled >-- Select an option --</option>
                        <?php
                        $sql="select * from `type_mission`";
                        $result = mysqli_query($con,$sql);
                        if (mysqli_num_rows($result) > 0 ) {
                        while($row=mysqli_fetch_assoc($result)){
                            echo '<option  value="'.$row["tm_id"].'" required';
                            if($row["tm_id"]== $tdm) echo ' selected';
                            echo '>'.$row["type_m"].'</option>';
                        }}   
                        ?>
                        <!-- <option value="" selected="true" disabled="disabled">Select Booking ID Type</option>
                            <option value="Booking_id_In">Online Booking</option>
                            <option value="walk">Walking Customer</option> -->
                      </select>
                    </div>
                    <!-- style="display:none;" -->
                    <div id="dispo_hr">
                     
                    </div>


                    </div>
                    <script>

                        <?php
if(isset($_GET['get_id'])){
?>
    showSelectOption(<?php echo '\''.$tdm.'\'';?>);
 
    document.getElementById("dispo_hr").value = "<?php echo $Dispo_Hours;?>";

<?php
}
?>




function showSelectOption(val) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("dispo_hr").innerHTML = this.responseText;
          
        }
    };
    xmlhttp.open("POST", "controller/getSelectOption", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("selectOption=" + val);
    
}


                    </script>
<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->