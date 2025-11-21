<!-- BLOCK#1 START DON'T CHANGE THE ORDER-->
<?php
$title = "Home | SLGTI";

include_once("head.php");
include_once("menu.php");

$u_n = $_SESSION['user']['username'];
$u_t = $_SESSION['user']['user_type'];
$u_p = $_SESSION['user']['profile'];

$required_menu_name = 'create_booking'; // ✅ MUST be defined before include
// echo "Checking menu: " . $required_menu_name;
 include 'auth_check.php'; 


$vn=$dn=$sq=$psq=$op_q=$tdm=$cd=$op_tel_q=$tti=$wg_q=$ppd_q=$pdd_q=$pl=$dl=null;
?>
<!--END DON'T CHANGE THE ORDER-->
<?php

// Fetch locations
$locations = [];
$result = $con->query("SELECT id, name FROM flight_locations ORDER BY name ASC");
while ($row = $result->fetch_assoc()) {
    $locations[] = $row;
}

if(isset($_GET['get_id'])){
  $pid=$_GET['get_id'];
  $sql="SELECT DISTINCT 
    p.passager_principal,
    p.date_de_prise_en_charge,
    p.Time,
    p.pickup_location,
    tt.type_tt,
    tt.tt_id,
    p.dropoff_location,
    p.nb_de_passager,
    p.user_id,
    p.Vehicule_num,
    p.chauffeur_desc,
    p.Tarif,
    p.tm_id,
    od.op_desc,
    od.op_question,
    pd.passenger_select_quesntion,
    pd.passenger_select_desc,
    ppd.ppd_desc,
    ppd.ppd_question,
    pdd.pdd_desc,
    pdd.pdd_question,
    tmd.type_desc,
    tmd.select_quesntion,
    u.username,
    u.phone,
    tm.type_m,
    ot.op_tel_question,
    ot.op_tel_desc,
    sao.tm_desc,
    wgb.wg_desc,
    wgb.wg_question
FROM passenger p
JOIN option_desc od ON p.p_id = od.p_id
JOIN passenger_description pd ON p.p_id = pd.p_id
JOIN passenger_pickup_desc ppd ON p.p_id = ppd.p_id
JOIN passenger_dropoff_desc pdd ON p.p_id = pdd.p_id
JOIN type_de_mission_desc tmd ON p.p_id = tmd.p_id
JOIN users u ON p.user_id = u.id
JOIN type_mission tm ON p.tm_id = tm.tm_id
JOIN option_tel ot ON p.p_id = ot.p_id
JOIN select_an_option_desc sao ON p.p_id = sao.p_id 
JOIN tarif_type tt ON p.tt_id = tt.tt_id
JOIN who_give_booking wgb ON p.p_id = wgb.p_id
-- add this only if needed:
-- JOIN users_desc ud ON u.id = ud.user_id
WHERE p.p_id = $pid;
";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)==1) {       
        $row=mysqli_fetch_assoc($result);
        $pp=$row['passager_principal'];
        $dd=$row['date_de_prise_en_charge'];
        $tm=$row['Time'];
        $pl=$row['pickup_location'];

        $dl=$row['dropoff_location'];

        $np=$row['nb_de_passager'];
        $dn=$row['user_id'];
        $dtn=$row['phone'];
        $vn=$row['Vehicule_num'];
       
        $ta=$row['Tarif'];
        $op_d=$row['op_desc'];
        $tdm=$row['tm_id'];
        $op_q=$row['op_question'];
        $psq=$row['passenger_select_quesntion'];
        $psd=$row['passenger_select_desc'];
        $td=$row['type_desc'];
        $sq=$row['select_quesntion'];
        $wg_q=$row['wg_question'];
        $wg=$row['wg_desc'];
        $ppd_q=$row['ppd_question'];
        $ppd=$row['ppd_desc'];
        $pdd_q=$row['pdd_question'];
        $pdd=$row['pdd_desc'];
        $op_tel_q=$row['op_tel_question'];
        $op_tel_desc=$row['op_tel_desc'];
        $Dispo_Hours=$row['tm_desc'];
        $tti=$row['tt_id'];
    }

}else {
        // ❌ No passenger found (or multiple rows when you expected one)
        $pp = $dd = $tm = $pl = $dl = $np = $dn = $dtn = $vn = $ta = $op_d = 
        $tdm = $op_q = $psq = $psd = $td = $sq = $wg_q = $wg = $ppd_q = 
        $ppd = $pdd_q = $pdd = $op_tel_q = $op_tel_desc = $Dispo_Hours = $tti = null;

        // Optional: Debug/log
        // echo "No passenger data found for ID $pid";
    }

$sql = "SELECT user_description 
        FROM users_desc 
        WHERE user_desc_id = 2 
        LIMIT 1";

$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $ud = $row['user_description'];
} else {
    $ud = null; // ❌ no description found
    // Optional: echo "No user description found for ID 2";
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
                      <label> Passager principal </label> 

                      <input type="text" id="text_input"  class="form-control"  placeholder="Enter ..." name="passager_principal" value="<?php if(isset($_GET['get_id'])){ echo $pp;}?>" required>



                      </div>
                    </div>
                    <!-- <div class="col-sm-6">
                      <div class="form-group">
                        <label> Contact Number </label> 
                        <input type="text" class="form-control" placeholder="Enter ..." style="display: block;"  id="cnum_on"  value="<?php if(isset($_GET['get_id'])){ echo $cn;}?>" name="contact_number" required>
                        <select class="form-control custom-select" style="display: none;"  id="cnum_off" name="c_num" disabled="disabled" required>
                        </select>
                      </div>
                    </div> -->
                   
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">                        
                        <label for="select_quesntion">Contact Number</label> | 
                        <input type="radio"  name="c_num" id="c_num" value="c_on" onclick="EnableCNum()"
                        <?php 
                        if($op_tel_q=='c_on') 
                        {
                          echo "checked";
                        }
                        ?> 
                        >Yes
                        <?php 
                        if(isset($_GET['get_id']) && $op_tel_q =='c_on'){  
                         ?>
                        <input type="radio"  name="c_num" id="c_num"  value="c_off" onclick="EnableCNum()"
                        <?php 
                        if($op_tel_q=='c_off') 
                        {
                          echo "checked";
                        }
                        ?>
                        >No |
                        <?php }else{?>
                        <input type="radio"  name="c_num" id="c_num" checked value="c_off" onclick="EnableCNum()">No |
                        <?php }?>
                        <?php 
                        if(isset($_GET['get_id']) && $op_tel_q =='c_on'){  
                        ?>
                        <input type="text" class="form-control" id="typeCnum" name="cNums" value="<?php if(isset($_GET['get_id'])){ echo $op_tel_desc;}?>"  placeholder="Type Desc">
                        <?php }else{?>
                        <input type="text" class="form-control" id="typeCnum" name="cNums" disabled="disabled"   placeholder="Type Desc">
                        <?php }?>
                 
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
                      <label for="selection">Type de mission</label>
                      <select class="form-control custom-select" style="width: 100%;" onchange="showSelectOption(this.value);" name="tm_id">
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

                    <div id="tm_id" style="display:none;"  class="col-sm-6">
                      <div  class="form-group">
                          <label for="text">Dispo Hours</label>
                          <input type="text" class="form-control" id="text" name="Dispo_desc" value="<?php if(isset($_GET['get_id'])){ echo $Dispo_Hours;}?>" >
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

                  <!-- <div class="row">
                    <div class="col-sm-6">
                     
                      <div class="form-group">
                        <label>Adresse du pick-up</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="adresse_du_pick_up" required><php if(isset($_GET['get_id'])){ echo (htmlspecialchars($pu)); } ?></textarea>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Adresse de dépose</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..."  name="adresse_de_depose" required><php if(isset($_GET['get_id'])){ echo (htmlspecialchars($dp));}?></textarea>
                      </div>
                    </div>
                  </div> -->


                          <!-- Pickup Location -->
<!-- Pickup Location -->
<div class="row">
  <div class="col-sm-6">
    <div class="form-group">
      <label>Pickup Location</label>
      <select name="pickup_location" id="pickup_location" class="form-control custom-select" required>
        <option value="">-- Select --</option>
        <?php foreach ($locations as $loc): ?>
          <option value="<?= $loc['id'] ?>" <?= ($loc['id'] == $pl) ? 'selected' : '' ?>>
            <?= htmlspecialchars($loc['name']) ?>
          </option>
        <?php endforeach; ?>
        <option value="others" <?= ($pl === 'others') ? 'selected' : '' ?>>Others</option>
      </select>
      
      <!-- <textarea name="adresse_du_pick_up" id="pickup_desc" class="form-control mt-2 hidden"
        placeholder="Enter pickup details"><php if(isset($_GET['get_id'])){ echo htmlspecialchars($pu); } ?>
      </textarea> -->

       <!-- text area start-->
      <div class="row" id="pickup_desc">
                    <div class="col-sm-12">
                      <div class="form-group">
                        
                        | <input type="radio" id="ppd_question" name="ppd_question" value="ppdOption"  onclick="Enable_ppdOptions()"
                        <?php 
                        if($ppd_q=='ppdOption') 
                        {
                          echo "checked";
                        }
                        ?> 
                        >Yes
                        <?php 
                        if(isset($_GET['get_id']) && $ppd_q =='ppdOption'){  
                         ?>
                        <input type="radio" id="ppd" name="ppd_question" value="No_ppdOption"  onclick="Enable_ppdOptions()"
                        <?php 
                        if($ppd_q=='No_ppdOption') 
                        {
                          echo "checked";
                        }
                        ?>
                        >No |
                        <?php }else{?>
                        <input type="radio" id="ppd" name="ppd_question" value="No_ppdOption" checked onclick="Enable_ppdOptions()">No | 
                        <?php }?>
                        <?php 
                        if(isset($_GET['get_id']) && $ppd_q=='ppdOption'){  
                        ?>
                        <textarea  class="form-control" id="Options_ppdEdit" name="ppd_desc" placeholder="Enter ... Desc"><?php if(isset($_GET['get_id'])){ echo htmlspecialchars($ppd);}?></textarea>
                        <?php }else{?>
                          <textarea  class="form-control" id="Options_ppdEdit" name="ppd_desc" disabled="disabled"  placeholder="Enter ... Desc"></textarea>
                        <?php }?>
                      </div>
                    </div>
                  </div>
                        <!-- text area end-->
    </div>
  </div>

  <div class="col-sm-6">
    <div class="form-group">
      <label>Drop-off Location</label>
      <select name="dropoff_location" id="dropoff_location" class="form-control custom-select" required>
        <option value="">-- Select --</option>
        <?php foreach ($locations as $loc): ?>
          <option value="<?= $loc['id'] ?>" <?= ($loc['id'] == $dl) ? 'selected' : '' ?>>
            <?= htmlspecialchars($loc['name']) ?>
          </option>
        <?php endforeach; ?>
        <option value="others" <?= ($dl === 'others') ? 'selected' : '' ?>>Others</option>
      </select>

                  <!-- text area start-->
                  <div class="row" id="dropoff_desc">
                    <div class="col-sm-12">
                      <div class="form-group">
                        
                        | <input type="radio" id="pdd_question" name="pdd_question" value="pddOption"  onclick="Enable_pddOptions()"
                        <?php 
                        if($pdd_q=='pddOption') 
                        {
                          echo "checked";
                        }
                        ?> 
                        >Yes
                        <?php 
                        if(isset($_GET['get_id']) && $pdd_q =='pddOption'){  
                         ?>
                        <input type="radio" id="ppd" name="pdd_question" value="No_pddOption"  onclick="Enable_pddOptions()"
                        <?php 
                        if($pdd_q=='No_pddOption') 
                        {
                          echo "checked";
                        }
                        ?>
                        >No |
                        <?php }else{?>
                        <input type="radio" id="ppd" name="pdd_question" value="No_pddOption" checked onclick="Enable_pddOptions()">No | 
                        <?php }?>
                        <?php 
                        if(isset($_GET['get_id']) && $pdd_q=='pddOption'){  
                        ?>
                             
                              <textarea class="form-control" id="Options_pddEdit" name="pdd_desc" placeholder="Enter ... Desc"
                                placeholder="Enter drop-off details"><?php if(isset($_GET['get_id'])){ echo htmlspecialchars($pdd); } ?>
                              </textarea>

                        <?php }else{?>

                              <textarea class="form-control" id="Options_pddEdit" name="pdd_desc" placeholder="Enter ... Desc" disabled="disabled" placeholder="Enter drop-off details">
                              </textarea>
                        <?php }?>
                      </div>
                    </div>
                  </div>
                  <!-- text area end-->


    </div>
  </div>
</div>


<style>
  .hidden {
    display: none;
  }
</style>





                  

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
<select class="form-control Chauffeur_select" style="width: 100%;" name="user_id" id="didx" onchange="showTelNum(this.value)">
    <option value="null" selected disabled>---- Select the Chauffeur ----</option>
    <?php
    $u_t = $_SESSION['user']['user_type']; // user type from session
    $user_id = $_SESSION['user']['id'];     // logged in user id

    // Base SQL
    $sql = "SELECT `id`, `username` FROM `users` WHERE `user_type`='driver'";

    if($u_t == 'driver') {
        // Driver sees only himself + "kutti"
        $sql .= " AND (`id` = $user_id OR `username` = 'Choisir un Chauffeur')";
    } elseif($u_t == 'user_enties') {
        // user_enties sees only "kutti"
        $sql .= " AND `username` = 'Choisir un Chauffeur'";
    } 
    // ADM and admin see all drivers → no extra condition

    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row["id"].'"';
            if(isset($dn) && $row["id"] == $dn) echo ' selected';
            echo '>'.$row["username"].'</option>';
        }
    }
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
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Chauffeur Desc</label>
                        <textarea class="form-control" rows="3"   name=""  disabled>

<?php echo $ud; ?>

                        </textarea>
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
                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Tarif</label>
                        <input type="text" class="form-control" placeholder="Enter ..." value="<?php if(isset($_GET['get_id'])){ echo $ta;}?>"name="Tarif" required>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Modes de Paiement</label>
                        <select class="form-control Vehicule_select" style="width: 100%;" name="Tarif_Types" id="vidx" value="<?php if(isset($_GET['get_id'])){ echo $tti;}?>" >
                        <option  selected disabled >---- Select the Type ---- </option>
                        <?php
                        $sql="select * from `tarif_type`";
                        $result = mysqli_query($con,$sql);
                        if (mysqli_num_rows($result) > 0 ) {
                        while($row=mysqli_fetch_assoc($result)){
                            echo '<option  value="'.$row["tt_id"].'" required';
                            if($row["tt_id"]== $tti) echo ' selected';
                            echo '>'.$row["type_tt"].'</option>';
                        }}   
                        ?>
                        </select>
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
                        <label>Who Given Booking</label> | 
                        <input type="radio" id="wg_question" name="wg_question" value="wgOption"  onclick="Enable_wgOptions()"
                        <?php 
                        if($wg_q=='wgOption') 
                        {
                          echo "checked";
                        }
                        ?> 
                        >Yes
                        <?php 
                        if(isset($_GET['get_id']) && $wg_q =='wgOption'){  
                         ?>
                        <input type="radio" id="op" name="wg_question" value="No_wgOption"  onclick="Enable_wgOptions()"
                        <?php 
                        if($wg_q=='No_wgOption') 
                        {
                          echo "checked";
                        }
                        ?>
                        >No |
                        <?php }else{?>
                        <input type="radio" id="op" name="wg_question" value="No_wgOption" checked onclick="Enable_wgOptions()">No | 
                        <?php }?>
                        <?php 
                        if(isset($_GET['get_id']) && $wg_q=='wgOption'){  
                        ?>
                        <input type="text" class="form-control" id="Options_wgEdit" name="wg_desc" placeholder="Enter ... Desc"  value="<?php if(isset($_GET['get_id'])){ echo $wg;}?>">
                        <?php }else{?>
                        <input type="text" class="form-control" id="Options_wgEdit" name="wg_desc" disabled="disabled"  placeholder="Enter ... Desc" >
                        <?php }?>
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

    !empty($_POST['date_de_prise_en_charge'])&& 
    !empty($_POST['Time'])&& 
    !empty($_POST['pickup_location'])&& 

    !empty($_POST['dropoff_location'])&& 

    !empty($_POST['nb_de_passager'])&& 
    !empty($_POST['user_id'])&&
    !empty($_POST['Vehicule_num'])&&
    !empty($_POST['Tarif'])&&
    !empty($_POST['Tarif_Types'])&&
    !empty($_POST['tm_id'])){
      
     
        $passager_principal=$_POST['passager_principal'];
 
        $date_de_prise_en_charge=$_POST['date_de_prise_en_charge'];
        $Time=$_POST['Time'];
        $pickup_location=$_POST['pickup_location'];
 
         $dropoff_location=$_POST['dropoff_location'];

        $nb_de_passager=$_POST['nb_de_passager'];
        $user_id=$_POST['user_id'];
        $Vehicule_num=$_POST['Vehicule_num'];
        $Tarif=$_POST['Tarif'];
        $Tarif_Types=$_POST['Tarif_Types'];
        $tm_id=$_POST['tm_id'];

        $sql='INSERT INTO `passenger` (`passager_principal`,`date_de_prise_en_charge`,`Time`,`pickup_location`,`dropoff_location`,`nb_de_passager`,`user_id`,`Vehicule_num`,`Tarif`,`tt_id`,`tm_id`) 
        values("'.$passager_principal.'","'.$date_de_prise_en_charge.'","'.$Time.'","'.$pickup_location.'","'.$dropoff_location.'","'.$nb_de_passager.'","'.$user_id.'","'.$Vehicule_num.'","'.$Tarif.'","'.$Tarif_Types.'","'.$tm_id.'")';
        if(mysqli_query($con,$sql)){

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
if ($_POST['passenger_select_quesntion'] == 'pdesc') {

    if (!empty($_POST['passenger_select_quesntion']) && !empty($_POST['passenger_select_desc'])) {

        $passenger_select_quesntion = $_POST['passenger_select_quesntion'];
        $passenger_select_desc      = $_POST['passenger_select_desc'];

        $sql = "INSERT INTO passenger_description 
                (p_id, passenger_select_quesntion, passenger_select_desc)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $id, $passenger_select_quesntion, $passenger_select_desc);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }

} else if ($_POST['passenger_select_quesntion'] == 'Nopdesc') {

    if (!empty($_POST['passenger_select_quesntion'])) {

        $passenger_select_quesntion = $_POST['passenger_select_quesntion'];
        $passenger_select_desc      = "Nopdesc";

        $sql = "INSERT INTO passenger_description 
                (p_id, passenger_select_quesntion, passenger_select_desc)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $id, $passenger_select_quesntion, $passenger_select_desc);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
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
          $message ="<h5>New record created successfully option</h5>";
          echo $message;
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
if ($_POST['select_quesntion'] == 'desc') {

    if (!empty($_POST['type_desc']) && !empty($_POST['select_quesntion'])) {

        $type_desc        = $_POST['type_desc'];
        $select_quesntion = $_POST['select_quesntion'];

        $sql = "INSERT INTO type_de_mission_desc (type_desc, select_quesntion, p_id)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $type_desc, $select_quesntion, $id);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }

} else if ($_POST['select_quesntion'] == 'Nodesc') {

    if (!empty($_POST['select_quesntion'])) {

        $select_quesntion = $_POST['select_quesntion'];
        $type_desc        = "Nodesc";

        $sql = "INSERT INTO type_de_mission_desc (type_desc, select_quesntion, p_id)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $type_desc, $select_quesntion, $id);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }
}



                   // <!--  passenger pickup desc text area -->          
if ($_POST['ppd_question'] === 'ppdOption') {

    if (!empty($_POST['ppd_desc']) && !empty($_POST['ppd_question'])) {

        $ppd_desc = $_POST['ppd_desc'];
        $ppd_question = $_POST['ppd_question'];

        $sql = "INSERT INTO passenger_pickup_desc (p_id, ppd_desc, ppd_question)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $id, $ppd_desc, $ppd_question);

        if (mysqli_stmt_execute($stmt)) {
            echo "<h5>New record created successfully option</h5>";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }

} else if ($_POST['ppd_question'] === 'No_ppdOption') {

    if (!empty($_POST['ppd_question'])) {

        $ppd_question = $_POST['ppd_question'];
        $ppd_desc = "No_ppdOption";

        $sql = "INSERT INTO passenger_pickup_desc (p_id, ppd_desc, ppd_question)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $id, $ppd_desc, $ppd_question);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }
}



                       // <!--  passenger Dropoff desc text area -->          
if ($_POST['pdd_question'] == 'pddOption') {

    if (!empty($_POST['pdd_desc']) && !empty($_POST['pdd_question'])) {

        $pdd_desc     = $_POST['pdd_desc'];
        $pdd_question = $_POST['pdd_question'];

        $sql = "INSERT INTO passenger_dropoff_desc (p_id, pdd_desc, pdd_question)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $id, $pdd_desc, $pdd_question);

        if (mysqli_stmt_execute($stmt)) {
            echo "<h5>New record created successfully option</h5>";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }

} else if ($_POST['pdd_question'] == 'No_pddOption') {

    if (!empty($_POST['pdd_question'])) {

        $pdd_question = $_POST['pdd_question'];
        $pdd_desc     = "No_pddOption";

        $sql = "INSERT INTO passenger_dropoff_desc (p_id, pdd_desc, pdd_question)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $id, $pdd_desc, $pdd_question);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }
}





    //who give booking           
    if($_POST['wg_question'] == 'wgOption'){
      if(!empty($_POST['wg_desc']) && !empty($_POST['wg_question'])){

      $wg_desc=$_POST['wg_desc'];
      $wg_question=$_POST['wg_question'];

      $sql="INSERT INTO `who_give_booking` (`p_id`,`wg_desc`,`wg_question`) 
      values('$id','$wg_desc','$wg_question')";
      if(mysqli_query($con,$sql)){
          $message ="<h5>New record created successfully option</h5>";
          echo $message;
      }else{
        echo "Error :-".$sql.
      "<br>"  .mysqli_error($con);
      }

    }}else if($_POST['wg_question'] == 'No_wgOption'){
      if(!empty($_POST['wg_question'])){

      $wg_question=$_POST['wg_question'];

      $sql="INSERT INTO `who_give_booking` (`p_id`,`wg_desc`,`wg_question`)  
      values('$id','No_wgOption','$wg_question')";
      if(mysqli_query($con,$sql)){
          //$message ="<h5>New record created successfully</h5>";
      }else{
        echo "Error :-".$sql.
      "<br>"  .mysqli_error($con);
      }

    }}


    //option_tel                    
if($_POST['c_num'] == 'c_on'){
    if(!empty($_POST['cNums']) && !empty($_POST['c_num'])){

    $cNums=$_POST['cNums'];
    $c_num=$_POST['c_num'];

    $sql="INSERT INTO `option_tel` (`p_id`,`op_tel_desc`,`op_tel_question`) 
    values('$id','$cNums','$c_num')";
    if(mysqli_query($con,$sql)){
        // $message ="<h5>New record created successfully option</h5>";
        // echo $message;
    }else{
      echo "Error :-".$sql.
    "<br>"  .mysqli_error($con);
    }

  }}else if($_POST['c_num'] == 'c_off'){
    if(!empty($_POST['c_num'])){

    $c_num=$_POST['c_num'];

    $sql="INSERT INTO `option_tel` (`p_id`,`op_tel_desc`,`op_tel_question`) 
    values('$id','c_off','$c_num')";
    if(mysqli_query($con,$sql)){
        //$message ="<h5>New record created successfully</h5>";
    }else{
      echo "Error :-".$sql.
    "<br>"  .mysqli_error($con);
    }

  }}

      //Select an option desc

    if($_POST['tm_id'] == '4'){
        if(!empty($_POST['Dispo_desc'])){

        $Dispo_desc=$_POST['Dispo_desc'];
        $tdi= $_POST['tm_id'];
  
        $sql="INSERT INTO `select_an_option_desc` (`p_id`,`tm_desc`,`tm_id`) 
        values('$id','$Dispo_desc','$tdi')";
        if(mysqli_query($con,$sql)){
            // $message ="<h5>New record created successfully Select an option desc</h5>";
            // echo $message;
        }else{
          echo "Error :-".$sql.
        "<br>"  .mysqli_error($con);
        }
  
      }}else{
            $tdi= $_POST['tm_id'];
      
            $sql="INSERT INTO `select_an_option_desc` (`p_id`,`tm_desc`,`tm_id`)
            values('$id','no_desc','$tdi')";
            if(mysqli_query($con,$sql)){
                // $message ="<h5>New record created successfully Select an option desc</h5>";
                // echo $message;
            }else{
              echo "Error :-".$sql.
            "<br>"  .mysqli_error($con);
            }  
      }
}
}
?>

<?php
if(isset($_POST['edit'])){
  if(!empty($_POST['passager_principal'])&& 
  !empty($_POST['date_de_prise_en_charge'])&& 
  !empty($_POST['Time'])&& 
   !empty($_POST['pickup_location'])&& 

  !empty($_POST['dropoff_location'])&& 

  !empty($_POST['nb_de_passager'])&& 
  !empty($_POST['user_id'])&&
  !empty($_POST['Vehicule_num'])&&
  // !empty($_POST['chauffeur_desc'])&&
  !empty($_POST['Tarif'])&&
  !empty($_POST['Tarif_Types'])&&
  !empty($_POST['tm_id'])){

      //     

    $passager_principal=$_POST['passager_principal'];
    $date_de_prise_en_charge=$_POST['date_de_prise_en_charge'];
    $Time=$_POST['Time'];
    $pickup_location=$_POST['pickup_location'];

    $dropoff_location=$_POST['dropoff_location'];

    $nb_de_passager=$_POST['nb_de_passager'];
    $user_id=$_POST['user_id'];
    $Vehicule_num=$_POST['Vehicule_num'];
    // $chauffeur_desc=$_POST['chauffeur_desc'];
    $Tarif=$_POST['Tarif'];
    $Tarif_Types=$_POST['Tarif_Types'];
    $tm_id=$_POST['tm_id'];



  $sql='UPDATE  `passenger` set 
  `passager_principal` ="'.$passager_principal.'",
  `date_de_prise_en_charge`="'.$date_de_prise_en_charge.'",
  `Time`="'.$Time.'",
  `pickup_location`="'.$pickup_location.'",

  `dropoff_location`="'.$dropoff_location.'",

  `nb_de_passager`="'.$nb_de_passager.'",
  `user_id`="'.$user_id.'",
  `Vehicule_num`="'.$Vehicule_num.'",
  `Tarif`="'.$Tarif.'",
  `tt_id`="'.$Tarif_Types.'",
  `tm_id`="'.$tm_id.'"

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


 //who give booking            
if($_POST['wg_question'] == 'wgOption'){
  if(!empty($_POST['wg_desc']) && !empty($_POST['wg_question'])){

  $wg_desc=$_POST['wg_desc'];
  $wg_question=$_POST['wg_question'];

  $sql='UPDATE  `who_give_booking` set 
  `wg_desc` ="'.$wg_desc.'",
  `wg_question`="'.$wg_question.'"
  
  where `p_id`="'.$pid.'"';
  if(mysqli_query($con,$sql)){
      //$message ="<h5>New record created successfully</h5>";

  }else{
    echo "Error :-".$sql.
  "<br>"  .mysqli_error($con);
  }

}}else if($_POST['wg_question'] == 'No_wgOption'){
  if(!empty($_POST['wg_question'])){

  $wg_question=$_POST['wg_question'];

  $sql='UPDATE  `who_give_booking` set 
  `wg_desc` = "No_wgOption",
  `wg_question`="'.$wg_question.'"
  
  where `p_id`="'.$pid.'"';
  if(mysqli_query($con,$sql)){
      //$message ="<h5>New record created successfully</h5>";
  }else{
    echo "Error :-".$sql.
  "<br>"  .mysqli_error($con);
  }

}}


//option_tel 
if($_POST['c_num'] == 'c_on'){
    if(!empty($_POST['cNums']) && !empty($_POST['c_num'])){
  
    $c_num=$_POST['c_num'];
    $cNums=$_POST['cNums'];
  
    $sql='UPDATE  `option_tel` set 
    `op_tel_desc` ="'.$cNums.'",
    `op_tel_question`="'.$c_num.'"
    
    where `p_id`="'.$pid.'"';
    if(mysqli_query($con,$sql)){
        //$message ="<h5>New record created successfully</h5>";
  
    }else{
      echo "Error :-".$sql.
    "<br>"  .mysqli_error($con);
    }
  
  }}else if($_POST['c_num'] == 'c_off'){
    if(!empty($_POST['c_num'])){
  
    $c_num=$_POST['c_num'];
  
    $sql='UPDATE  `option_tel` set 
    `op_tel_desc` = "c_off",
    `op_tel_question`="'.$c_num.'"
    
    where `p_id`="'.$pid.'"';
    if(mysqli_query($con,$sql)){
        //$message ="<h5>New record created successfully</h5>";
    }else{
      echo "Error :-".$sql.
    "<br>"  .mysqli_error($con);
    }
  
  }}
  




//type_de_mission_desc
if ($_POST['select_quesntion'] == 'desc') {

    if (!empty($_POST['type_desc']) && !empty($_POST['select_quesntion'])) {

        $type_desc        = $_POST['type_desc'];
        $select_quesntion = $_POST['select_quesntion'];

        $sql = "UPDATE type_de_mission_desc
                SET type_desc = ?, select_quesntion = ?
                WHERE p_id = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $type_desc, $select_quesntion, $pid);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }

} else if ($_POST['select_quesntion'] == 'Nodesc') {

    if (!empty($_POST['select_quesntion'])) {

        $select_quesntion = $_POST['select_quesntion'];
        $type_desc        = "Nodesc";

        $sql = "UPDATE type_de_mission_desc
                SET type_desc = ?, select_quesntion = ?
                WHERE p_id = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $type_desc, $select_quesntion, $pid);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }
}



    
 // <!--  passenger pickup desc text area -->            
if ($_POST['ppd_question'] == 'ppdOption') {

    if (!empty($_POST['ppd_desc']) && !empty($_POST['ppd_question'])) {

        $ppd_desc     = $_POST['ppd_desc'];
        $ppd_question = $_POST['ppd_question'];

        $sql = "UPDATE passenger_pickup_desc 
                SET ppd_desc = ?, ppd_question = ?
                WHERE p_id = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $ppd_desc, $ppd_question, $pid);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }

} else if ($_POST['ppd_question'] == 'No_ppdOption') {

    if (!empty($_POST['ppd_question'])) {

        $ppd_question = $_POST['ppd_question'];
        $ppd_desc     = "No_ppdOption";

        $sql = "UPDATE passenger_pickup_desc 
                SET ppd_desc = ?, ppd_question = ?
                WHERE p_id = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $ppd_desc, $ppd_question, $pid);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }
}



        
 // <!--  passenger dropoff desc text area -->            
if ($_POST['pdd_question'] == 'pddOption') {

    if (!empty($_POST['pdd_desc']) && !empty($_POST['pdd_question'])) {

        $pdd_desc     = $_POST['pdd_desc'];
        $pdd_question = $_POST['pdd_question'];

        $sql = "UPDATE passenger_dropoff_desc 
                SET pdd_desc = ?, pdd_question = ?
                WHERE p_id = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $pdd_desc, $pdd_question, $pid);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }

} else if ($_POST['pdd_question'] == 'No_pddOption') {

    if (!empty($_POST['pdd_question'])) {

        $pdd_question = $_POST['pdd_question'];
        $pdd_desc     = "No_pddOption";

        $sql = "UPDATE passenger_dropoff_desc 
                SET pdd_desc = ?, pdd_question = ?
                WHERE p_id = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $pdd_desc, $pdd_question, $pid);

        if (!mysqli_stmt_execute($stmt)) {
            echo "Error: " . mysqli_error($con);
        }
    }
}





//select option desc
if($_POST['tm_id'] == '4'){
    if(!empty($_POST['Dispo_desc'])){
  
    $Dispo_desc=$_POST['Dispo_desc'];
    $tdi= $_POST['tm_id'];
  
    $sql='UPDATE  `select_an_option_desc` set 
    `tm_desc` ="'.$Dispo_desc.'",
    `tm_id` ="'.$tdi.'"
  
    where `p_id`="'.$pid.'"';
    if(mysqli_query($con,$sql)){
        $message ="<h5>New record created successfully pass</h5>";
        echo $message;
    }else{
      echo "Error :-".$sql.
    "<br>"  .mysqli_error($con);
    }
  
    }
  }elseif($_POST['tm_id'] == '1' || $_POST['tm_id'] == '2' || $_POST['tm_id'] == '3'){

  
    $tdi= $_POST['tm_id'];
      
        $sql='UPDATE  `select_an_option_desc` set 
        `tm_desc` ="no_desc",
        `tm_id` ="'.$tdi.'"
      
        where `p_id`="'.$pid.'" and `tm_id`="'.$tdm.'"';
        if(mysqli_query($con,$sql)){
            //$message ="<h5>New record created successfully</h5>";
        }else{
          echo "Error :-".$sql.
        "<br>"  .mysqli_error($con);
        }
  
}

  
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




//hjghjk
<?php
if(isset($_GET['get_id'])){
?>
    showSelectOption(<?php echo '\''.$tdm.'\'';?>);
 
    document.getElementById("Dispo_Hours").value = "<?php echo $Dispo_Hours;?>";
<?php
}
?>

function showSelectOption(val) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("Dispo_Hours").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("POST", "controller/getSelectOption", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("selectOption=" + val);
}

  function showTelNum(val) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tel_num").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("POST", "controller/getTelNum", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("users=" + val);
}

</script>



<!--BLOCK#3 START DON'T CHANGE THE ORDER-->
<?php include_once("footer.php"); ?>
<!--END DON'T CHANGE THE ORDER-->