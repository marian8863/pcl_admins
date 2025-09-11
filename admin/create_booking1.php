<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];


$vn=$dn=$sq=$psq=$op_q=$tdm=$pp=$cd=null;
?>
<!--END DON'T CHANGE THE ORDER-->
<?php

if(isset($_GET['get_id'])){
  $pid=$_GET['get_id'];
  $sql="SELECT passenger.passager_principal,passenger.contact_number,passenger.date_de_prise_en_charge,passenger.Time,passenger.adresse_du_pick_up,
  passenger.adresse_de_depose,passenger.nb_de_passager,passenger.d_id,passenger.Vehicule_num,passenger.Tarif,passenger.tm_id,passenger.whogiven,option_desc.op_desc,option_desc.op_question,passenger_description.passenger_select_quesntion,
  passenger_description.passenger_select_desc,type_de_mission_desc.type_desc,type_de_mission_desc.select_quesntion,driver.dname,driver.dtp_num,type_mission.type_m
  
  
  from passenger ,option_desc,passenger_description ,type_de_mission_desc,driver,type_mission
  
  WHERE passenger.p_id=option_desc.p_id and passenger.p_id=passenger_description.p_id and passenger.p_id=type_de_mission_desc.p_id and passenger.tm_id=type_mission.tm_id and passenger.d_id=driver.d_id and 
  passenger.p_id=$pid";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)==1) {       
        $row=mysqli_fetch_assoc($result);
        $pp=$row['passager_principal'];
        $cn=$row['contact_number'];
        $dd=$row['date_de_prise_en_charge'];
        $tm=$row['Time'];
        $pu=$row['adresse_du_pick_up'];
        $dp=$row['adresse_de_depose'];
        $np=$row['nb_de_passager'];
        $dn=$row['d_id'];
        $dtn=$row['dtp_num'];
        $vn=$row['Vehicule_num'];
        $ta=$row['Tarif'];
        $op_d=$row['op_desc'];
        $tdm=$row['tm_id'];
        $op_q=$row['op_question'];
        $psq=$row['passenger_select_quesntion'];
        $psd=$row['passenger_select_desc'];
        $td=$row['type_desc'];
        $sq=$row['select_quesntion'];
        $wg=$row['whogiven'];
     

        

        

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
            <h1 class="m-0 text-dark">Create Job Detail</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create Job Detail
              <?php
                  // echo  $Sdate = new DateTime("now", new DateTimeZone('Asia/Colombo'));
                  // date_default_timezone_set('Asia/Colombo');
                  // $date = date('d-m-y h:i:s');
                  // echo $date;
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
                    <h3 class="card-title">Edit Passenger</h3>
                <?php
                }else{
                ?>
                <h3 class="card-title">Create Passenger</h3>
                <?php
                }
                ?>
            </div>
      
                <!-- /.card-header -->
                <div class="card-body">
                <form action="" method="POST"> 
                 <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                      <label>Passager principal</label>
                      <input type="radio" name="option" id="radioText" checked="checked" onclick="showTextBox()"
                     >
    
                      <label>Company</label>
                      <input type="radio" name="option" id="radioCombo" onclick="showComboBox()">



                      <input type="text" id="textBox"   class="form-control" placeholder="Enter ..." name="passager_principal" value="<?php if(isset($_GET['get_id'])){ echo $pp;}?>" required>


                      <select class="form-control custom-select " name="passager_principal" id="comboBox"  style="display: none;"    onchange="showCompanyTelNum(this.value)">
                      <option value="null" selected disabled >-- Select Company --</option>
                      <?php
                        $sql="select * from `company`";
                        $result = mysqli_query($con,$sql);
                        if (mysqli_num_rows($result) > 0 ) {
                        while($row=mysqli_fetch_assoc($result)){
                            echo '<option  value="'.$row["c_id"].'" required';
                            if($row["c_id"]== $pp) echo ' selected';
                            echo '>'.$row["company_name"].'</option>';
                        }}   
                      ?>
                      </select>


                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <!-- <input type="radio" id="radio1" name="choice" checked onclick="showInput()"> -->
                        <label> Contact Number </label> 
                        <!-- <input type="radio" id="radio2"  name="choice" onclick="showInput()"> -->
                        <!-- <label> Company Number</label> -->
                        <input type="text" class="form-control " placeholder="Enter ..."  id="cnum_on"  value="<?php if(isset($_GET['get_id'])){ echo $cn;}?>" name="contact_number" required>
                        <!-- <input type="text" id="cnum_off"  class="form-control" name="c_num" disabled="disabled" style="display: none;" placeholder="Text box"> -->
                        <select class="form-control custom-select hidden" name="contact_number"   id="cnum_off" name="c_num" disabled="disabled" required>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Date de prise en charge</label>
                        <input type="date" class="form-control" placeholder="Enter ..." value="<?php if(isset($_GET['get_id'])){ echo $dd;}?>" name="date_de_prise_en_charge" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Time</label>
                        <input type="time" class="form-control" placeholder="Enter ..." value="<?php if(isset($_GET['get_id'])){ echo $tm;}?>" name="Time" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <label for="selection">Select an option:</label>
                      <select class="form-control custom-select" style="width: 100%;" name="tm_id" id="selection" >
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
                      </select>
                    </div>

                    <div id="textbox" class="col-sm-6 hidden">
                      <div  class="form-group">
                          <label for="text">Dispo Hours</label>
                          <input type="text" class="form-control" id="text" name="text">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">                        
                        <label for="select_quesntion">Type de mission Desc</label> | 
                        <input type="radio"  name="select_quesntion" id="select_quesntion" value="desc" onclick="EnableType()"
                        <?php 
                        if($sq=='desc') 
                        {
                          echo "checked";
                        }
                        ?> 
                        >Yes
                        <?php 
                        if(isset($_GET['get_id']) && $sq =='desc'){  
                         ?>
                        <input type="radio"  name="select_quesntion" id="select_quesntion"  value="Nodesc" onclick="EnableType()"
                        <?php 
                        if($sq=='Nodesc') 
                        {
                          echo "checked";
                        }
                        ?>
                        >No |
                        <?php }else{?>
                        <input type="radio"  name="select_quesntion" id="select_quesntion" checked value="Nodesc" onclick="EnableType()">No |
                        <?php }?>
                        <?php 
                        if(isset($_GET['get_id']) && $sq =='desc'){  
                        ?>
                        <input type="text" class="form-control" id="typedescrib" name="type_desc" value="<?php if(isset($_GET['get_id'])){ echo $td;}?>"  placeholder="Type Desc">
                        <?php }else{?>
                        <input type="text" class="form-control" id="typedescrib" name="type_desc" disabled="disabled"   placeholder="Type Desc">
                        <?php }?>
                 
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Adresse du pick-up</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="adresse_du_pick_up" required><?php if(isset($_GET['get_id'])){ echo $pu;}?></textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Adresse de dépose</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..."  name="adresse_de_depose" required><?php if(isset($_GET['get_id'])){ echo $dp;}?></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <!-- textarea -->
                      <div class="form-group">
                        <label>Nb. de passager</label>
                        <input type="text" class="form-control" placeholder="Enter ..." value="<?php if(isset($_GET['get_id'])){ echo $np;}?>" name="nb_de_passager" required >
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">                        
                        <label>Passenger Description</label> | 
                        <input type="radio" id="passengerdesc" name="passenger_select_quesntion" value="pdesc"  onclick="EnablePassengerType()"
                        <?php 
                        if($psq=='pdesc') 
                        {
                          echo "checked";
                        }
                        ?> 
                        >Yes
                        <?php 
                        if(isset($_GET['get_id']) && $psq =='pdesc'){  
                         ?>
                        <input type="radio" id="pd" name="passenger_select_quesntion" value="Nopdesc"  onclick="EnablePassengerType()"
                        <?php 
                        if($psq=='Nopdesc') 
                        {
                          echo "checked";
                        }
                        ?>
                        >No |
                        <?php }else{?>
                        <input type="radio" id="pd" name="passenger_select_quesntion" value="Nopdesc" checked  onclick="EnablePassengerType()">No | 
                        <?php }?>
                        <?php 
                        if(isset($_GET['get_id']) && $psq =='pdesc'){  
                        ?>
                        <input type="text" class="form-control" id="passengerdescrib" name="passenger_select_desc"  value="<?php if(isset($_GET['get_id'])){ echo $psd;}?>"  placeholder="Passenger Desc">
                        <?php }else{?>
                        <input type="text" class="form-control" id="passengerdescrib" name="passenger_select_desc" disabled="disabled"   placeholder="Passenger Desc">
                        <?php }?>
                 
                        
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Chauffeur</label>
                        <select class="form-control Chauffeur_select" style="width: 100%;" name="d_id" id="didx"  onchange="showTelNum(this.value)" >
                        <option value="null" selected disabled >---- Select the Chauffeur ---- </option>
                        <?php
                        $sql="select * from `driver`";
                        $result = mysqli_query($con,$sql);
                        if (mysqli_num_rows($result) > 0 ) {
                        while($row=mysqli_fetch_assoc($result)){
                            echo '<option  value="'.$row["d_id"].'" required';
                            if($row["d_id"]== $dn) echo ' selected';
                            echo '>'.$row["dname"].'</option>';
                        }}   
                        ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Chauffeur Contact Number</label>
                        <select class="form-control select2" style="width: 100%;" id="tel_num" name="tel_id" disabled="disabled" required>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Véhicule</label>
                        <select class="form-control Vehicule_select" style="width: 100%;" name="Vehicule_num" id="vidx" value="<?php if(isset($_GET['get_id'])){ echo $vn;}?>" >
                        <option  selected disabled >---- Select the Véhicule ---- </option>
                        <?php
                        $sql="select * from `vehicule`";
                        $result = mysqli_query($con,$sql);
                        if (mysqli_num_rows($result) > 0 ) {
                        while($row=mysqli_fetch_assoc($result)){
                            echo '<option  value="'.$row["v_id"].'" required';
                            if($row["v_id"]== $vn) echo ' selected';
                            echo '>'.$row["Vehicule_num"].'</option>';
                        }}   
                        ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Tarif</label>
                        <input type="text" class="form-control" placeholder="Enter ..." value="<?php if(isset($_GET['get_id'])){ echo $ta;}?>"name="Tarif" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Options</label> | 
                        <input type="radio" id="op_question" name="op_question" value="OnOption"  onclick="EnableOptions()"
                        <?php 
                        if($op_q=='OnOption') 
                        {
                          echo "checked";
                        }
                        ?> 
                        >Yes
                        <?php 
                        if(isset($_GET['get_id']) && $op_q =='OnOption'){  
                         ?>
                        <input type="radio" id="op" name="op_question" value="NoOption"  onclick="EnableOptions()"
                        <?php 
                        if($op_q=='NoOption') 
                        {
                          echo "checked";
                        }
                        ?>
                        >No |
                        <?php }else{?>
                        <input type="radio" id="op" name="op_question" value="NoOption" checked onclick="EnableOptions()">No | 
                        <?php }?>
                        <?php 
                        if(isset($_GET['get_id']) && $op_q=='OnOption'){  
                        ?>
                        <input type="text" class="form-control" id="OptionsEdit" name="op_desc" placeholder="Enter ... Desc"  value="<?php if(isset($_GET['get_id'])){ echo $op_d;}?>">
                        <?php }else{?>
                        <input type="text" class="form-control" id="OptionsEdit" name="op_desc" disabled="disabled"  placeholder="Enter ... Desc" >
                        <?php }?>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Who Given Booking</label> 
                        <input type="text" class="form-control" id="whogiven" name="whogiven"  placeholder="Enter ..."  value="<?php if(isset($_GET['get_id'])){ echo $wg;}?>" required>
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
                        <input type="submit" class="btn btn-danger btn-block" value="- Edit Booking" name="edit">
                        <?php
                        }else{
                        ?>
                        <input type="submit" class="btn btn-primary btn-block" value="+ Add Booking" name="add">
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


  <?php
if(isset($_POST['add'])){

    if(!empty($_POST['passager_principal'])&& 
    !empty($_POST['contact_number'])&& 
    !empty($_POST['date_de_prise_en_charge'])&& 
    !empty($_POST['Time'])&& 
    !empty($_POST['adresse_du_pick_up'])&& 
    !empty($_POST['adresse_de_depose'])&& 
    !empty($_POST['nb_de_passager'])&& 
    !empty($_POST['d_id'])&&
    !empty($_POST['Vehicule_num'])&&
    !empty($_POST['Tarif'])&&
    !empty($_POST['tm_id'])&&
    !empty($_POST['whogiven'])){

        
        $passager_principal=$_POST['passager_principal'];
        $contact_number=$_POST['contact_number'];
        $date_de_prise_en_charge=$_POST['date_de_prise_en_charge'];
        $Time=$_POST['Time'];
        $adresse_du_pick_up=$_POST['adresse_du_pick_up'];
        $adresse_de_depose=$_POST['adresse_de_depose'];
        $nb_de_passager=$_POST['nb_de_passager'];
        $d_id=$_POST['d_id'];
        $Vehicule_num=$_POST['Vehicule_num'];
        $Tarif=$_POST['Tarif'];
        $tm_id=$_POST['tm_id'];
        $whogiven=$_POST['whogiven'];

        $sql='INSERT INTO `passenger` (`passager_principal`,`contact_number`,`date_de_prise_en_charge`,`Time`,`adresse_du_pick_up`,`adresse_de_depose`,`nb_de_passager`,`d_id`,`Vehicule_num`,`Tarif`,`tm_id`,`whogiven`) 
        values("'.$passager_principal.'","'.$contact_number.'","'.$date_de_prise_en_charge.'","'.$Time.'","'.$adresse_du_pick_up.'","'.$adresse_de_depose.'","'.$nb_de_passager.'","'.$d_id.'","'.$Vehicule_num.'","'.$Tarif.'","'.$tm_id.'","'.$whogiven.'")';
        if(mysqli_query($con,$sql)){
        // $sql="INSERT INTO `passenger` (`passager_principal`,`contact_number`,`date_de_prise_en_charge`,`Time`,`adresse_du_pick_up`,`adresse_de_depose`,`nb_de_passager`,`d_id`,`Vehicule_num`,`Tarif`,`tm_id`,`whogiven`) 
        // values('$passager_principal','$contact_number','$date_de_prise_en_charge','$Time','$adresse_du_pick_up','$adresse_de_depose','$nb_de_passager','$d_id','$Vehicule_num','$Tarif','$tm_id','$whogiven')";
        // if(mysqli_query($con,$sql)){
            //$message ="<h5>New record created successfully</h5>";
          echo '<script>';
          echo '
          Swal.fire({
             position: "top-end",
         
             icon: "success",
             title: "Your Booking has been saved",
             showConfirmButton: false,
            
             timer: 1500
           }).then(function() {
             // Redirect the user
             window.location.href = "view_passenger";
         
             });
          ';
          echo '</script>';  
        }else{
            echo "Error :-".$sql.
          "<br>"  .mysqli_error($con);
        }
    }
    $id = $con->insert_id;


// passenger desc
if($id !=0){
if($_POST['passenger_select_quesntion'] == 'pdesc'){
  if(!empty($_POST['passenger_select_quesntion']) && !empty($_POST['passenger_select_desc'])){

  $passenger_select_quesntion=$_POST['passenger_select_quesntion'];
  $passenger_select_desc=$_POST['passenger_select_desc'];

  $sql="INSERT INTO `passenger_description` (`p_id`,`passenger_select_quesntion`,`passenger_select_desc`) 
  values('$id','$passenger_select_quesntion','$passenger_select_desc')";
  if(mysqli_query($con,$sql)){
      //$message ="<h5>New record created successfully</h5>";

  }else{
      echo "Error :-".$sql.
    "<br>"  .mysqli_error($con);
  }
}

}else if($_POST['passenger_select_quesntion'] == 'Nopdesc'){
if(!empty($_POST['passenger_select_quesntion'])){

$passenger_select_quesntion=$_POST['passenger_select_quesntion'];

$sql="INSERT INTO `passenger_description` (`p_id`,`passenger_select_quesntion`,`passenger_select_desc`) 
values('$id','$passenger_select_quesntion','Nopdesc')";
if(mysqli_query($con,$sql)){
    //$message ="<h5>New record created successfully</h5>";

}else{
    echo "Error :-".$sql.
  "<br>"  .mysqli_error($con);
}
}

} 


//option_desc            
    if($_POST['op_question'] == 'OnOption'){
      if(!empty($_POST['op_desc']) && !empty($_POST['op_question'])){

      $op_desc=$_POST['op_desc'];
      $op_question=$_POST['op_question'];

      $sql="INSERT INTO `option_desc` (`p_id`,`op_desc`,`op_question`) 
      values('$id','$op_desc','$op_question')";
      if(mysqli_query($con,$sql)){
          //$message ="<h5>New record created successfully</h5>";
      }else{
        echo "Error :-".$sql.
      "<br>"  .mysqli_error($con);
      }

    }}else if($_POST['op_question'] == 'NoOption'){
      if(!empty($_POST['op_question'])){

      $op_question=$_POST['op_question'];

      $sql="INSERT INTO `option_desc` (`p_id`,`op_desc`,`op_question`) 
      values('$id','NoOption','$op_question')";
      if(mysqli_query($con,$sql)){
          //$message ="<h5>New record created successfully</h5>";
      }else{
        echo "Error :-".$sql.
      "<br>"  .mysqli_error($con);
      }

    }}


    
//type_de_mission_desc
if($_POST['select_quesntion'] == 'desc'){
  if(!empty($_POST['type_desc']) && !empty($_POST['select_quesntion'])){

  $type_desc=$_POST['type_desc'];
  $select_quesntion=$_POST['select_quesntion'];

  $sql="INSERT INTO `type_de_mission_desc` (`type_desc`,`select_quesntion`,`p_id`) 
  values('$type_desc','$select_quesntion','$id')";
  if(mysqli_query($con,$sql)){
      //$message ="<h5>New record created successfully</h5>";
  }else{
    echo "Error :-".$sql.
  "<br>"  .mysqli_error($con);
  }

  }
}else if($_POST['select_quesntion'] == 'Nodesc'){
if(!empty($_POST['select_quesntion'])){

$select_quesntion=$_POST['select_quesntion'];

$sql="INSERT INTO `type_de_mission_desc` (`type_desc`,`select_quesntion`,`p_id`) 
values('Nodesc','$select_quesntion','$id')";
if(mysqli_query($con,$sql)){
    //$message ="<h5>New record created successfully</h5>";
}else{
  echo "Error :-".$sql.
"<br>"  .mysqli_error($con);
}

}


}
}
}
?>

<?php
if(isset($_POST['edit'])){
  if(!empty($_POST['passager_principal'])&& 
  !empty($_POST['contact_number'])&& 
  !empty($_POST['date_de_prise_en_charge'])&& 
  !empty($_POST['Time'])&& 
  !empty($_POST['adresse_du_pick_up'])&& 
  !empty($_POST['adresse_de_depose'])&& 
  !empty($_POST['nb_de_passager'])&& 
  !empty($_POST['d_id'])&&
  !empty($_POST['Vehicule_num'])&&
  !empty($_POST['Tarif'])&&
  !empty($_POST['tm_id'])&&
  !empty($_POST['whogiven'])){

    $passager_principal=$_POST['passager_principal'];
    $contact_number=$_POST['contact_number'];
    $date_de_prise_en_charge=$_POST['date_de_prise_en_charge'];
    $Time=$_POST['Time'];
    $adresse_du_pick_up=$_POST['adresse_du_pick_up'];
    $adresse_de_depose=$_POST['adresse_de_depose'];
    $nb_de_passager=$_POST['nb_de_passager'];
    $d_id=$_POST['d_id'];
    $Vehicule_num=$_POST['Vehicule_num'];
    $Tarif=$_POST['Tarif'];
    $tm_id=$_POST['tm_id'];
    $whogiven=$_POST['whogiven'];



  $sql='UPDATE  `passenger` set 
  `passager_principal` ="'.$passager_principal.'",
  `contact_number`="'.$contact_number.'",
  `date_de_prise_en_charge`="'.$date_de_prise_en_charge.'",
  `Time`="'.$Time.'",
  `adresse_du_pick_up`="'.$adresse_du_pick_up.'",
  `adresse_de_depose`="'.$adresse_de_depose.'",
  `nb_de_passager`="'.$nb_de_passager.'",
  `d_id`="'.$d_id.'",
  `Vehicule_num`="'.$Vehicule_num.'",
  `Tarif`="'.$Tarif.'",
  `tm_id`="'.$tm_id.'",
  `whogiven`="'.$whogiven.'"

  where `p_id`="'.$pid.'"';

  if(mysqli_query($con,$sql)){
   
    //$message ="<h4 class='text-success' >Update successfully</h4>";
    echo '<script>';
    echo '
    Swal.fire({
       position: "top-end",
   
       icon: "success",
       title: "Your Passenger has been updated",
       showConfirmButton: false,
      
       timer: 1500
     }).then(function() {
       // Redirect the user
       window.location.href = "view_passenger";
   
       });
    ';
    echo '</script>';

}else{
    echo "Error :-".$sql.
  "<br>"  .mysqli_error($con);
}
}




//option_desc            
if($_POST['op_question'] == 'OnOption'){
  if(!empty($_POST['op_desc']) && !empty($_POST['op_question'])){

  $op_desc=$_POST['op_desc'];
  $op_question=$_POST['op_question'];

  $sql='UPDATE  `option_desc` set 
  `op_desc` ="'.$op_desc.'",
  `op_question`="'.$op_question.'"
  
  where `p_id`="'.$pid.'"';
  if(mysqli_query($con,$sql)){
      //$message ="<h5>New record created successfully</h5>";

  }else{
    echo "Error :-".$sql.
  "<br>"  .mysqli_error($con);
  }

}}else if($_POST['op_question'] == 'NoOption'){
  if(!empty($_POST['op_question'])){

  $op_question=$_POST['op_question'];

  $sql='UPDATE  `option_desc` set 
  `op_desc` = "NoOption",
  `op_question`="'.$op_question.'"
  
  where `p_id`="'.$pid.'"';
  if(mysqli_query($con,$sql)){
      //$message ="<h5>New record created successfully</h5>";
  }else{
    echo "Error :-".$sql.
  "<br>"  .mysqli_error($con);
  }

}}

//type_de_mission_desc
if($_POST['select_quesntion'] == 'desc'){
  if(!empty($_POST['type_desc']) && !empty($_POST['select_quesntion'])){

  $type_desc=$_POST['type_desc'];
  $select_quesntion=$_POST['select_quesntion'];

  $sql='UPDATE  `type_de_mission_desc` set 
  `type_desc` ="'.$type_desc.'",
  `select_quesntion`="'.$select_quesntion.'"

  where `p_id`="'.$pid.'"';
  if(mysqli_query($con,$sql)){
      //$message ="<h5>New record created successfully</h5>";
  }else{
    echo "Error :-".$sql.
  "<br>"  .mysqli_error($con);
  }

  }
}else if($_POST['select_quesntion'] == 'Nodesc'){
if(!empty($_POST['select_quesntion'])){

$select_quesntion=$_POST['select_quesntion'];

$sql='UPDATE  `type_de_mission_desc` set 
`type_desc` ="Nodesc",
`select_quesntion`="'.$select_quesntion.'"

where `p_id`="'.$pid.'"';
if(mysqli_query($con,$sql)){
    //$message ="<h5>New record created successfully</h5>";
}else{
  echo "Error :-".$sql.
"<br>"  .mysqli_error($con);
}

}}

  
// passenger desc

if($_POST['passenger_select_quesntion'] == 'pdesc'){
  if(!empty($_POST['passenger_select_quesntion']) && !empty($_POST['passenger_select_desc'])){

  $passenger_select_quesntion=$_POST['passenger_select_quesntion'];
  $passenger_select_desc=$_POST['passenger_select_desc'];

  $sql='UPDATE  `passenger_description` set 
  `passenger_select_quesntion` ="'.$passenger_select_quesntion.'",
  `passenger_select_desc`="'.$passenger_select_desc.'"

  where `p_id`="'.$pid.'"';
  if(mysqli_query($con,$sql)){
      //$message ="<h5>New record created successfully</h5>";

  }else{
      echo "Error :-".$sql.
    "<br>"  .mysqli_error($con);
  }
}

}else if($_POST['passenger_select_quesntion'] == 'Nopdesc'){
if(!empty($_POST['passenger_select_quesntion'])){

$passenger_select_quesntion=$_POST['passenger_select_quesntion'];

$sql='UPDATE  `passenger_description` set 
`passenger_select_quesntion` ="'.$passenger_select_quesntion.'",
`passenger_select_desc`="Nopdesc"

where `p_id`="'.$pid.'"';
if(mysqli_query($con,$sql)){
    //$message ="<h5>New record created successfully</h5>";

}else{
    echo "Error :-".$sql.
  "<br>"  .mysqli_error($con);
}
}} 



}
?>


<!--BLOCK#2 end YOUR CODE HERE -->


<script>

<?php
if(isset($_GET['get_id'])){
?>
    showTelNum(<?php echo '\''.$dn.'\'';?>);
 
    document.getElementById("tel_num").value = "<?php echo $dtn;?>";
<?php
}
?>

<?php
if(isset($_GET['get_id'])){
?>
    showTelNum(<?php echo '\''.$pp.'\'';?>);
 
    document.getElementById("cnum_off").value = "<?php echo $cn;?>";
<?php
}
?>

  function showTelNum(val) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tel_num").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("POST", "controller/getTelNum", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("driver=" + val);
}


function showCompanyTelNum(val) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("cnum_off").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("POST", "controller/getCompanyTelNum", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("company_num=" + val);
}

</script>

<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->