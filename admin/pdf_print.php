
<?php
include '../config.php';

if(isset($_GET['get_id'])){
    $pid=$_GET['get_id'];
    $sql="SELECT 
    passenger.passager_principal,
    passenger.date_de_prise_en_charge,
    passenger.Time,
    passenger.pickup_location,
    passenger.dropoff_location,
    pickup.name  AS pickup_adr,
    dropoff.name AS dropoff_adr,
    passenger.nb_de_passager,
    passenger.user_id,
    passenger.chauffeur_desc,
    users.id,
    users.username,
    users.phone,
    users_desc.user_description,
    passenger.Tarif,
    tarif_type.type_tt,
    select_an_option_desc.tm_id,
    type_mission.type_m,
    option_tel.op_tel_desc,
    option_tel.op_tel_question,
    vehicule.Vehicule_num,
    type_de_mission_desc.type_desc,
    type_de_mission_desc.select_quesntion,
    passenger_description.passenger_select_desc,
    passenger_description.passenger_select_quesntion,
    option_desc.op_desc,
    option_desc.op_question,
    select_an_option_desc.tm_desc,
    who_give_booking.wg_desc,
    who_give_booking.wg_question,
    passenger_pickup_desc.ppd_desc,
    passenger_pickup_desc.ppd_question,
    passenger_dropoff_desc.pdd_desc,
    passenger_dropoff_desc.pdd_question
FROM passenger
JOIN option_tel             ON passenger.p_id = option_tel.p_id
JOIN vehicule               ON vehicule.v_id = passenger.Vehicule_num
JOIN type_mission           ON type_mission.tm_id = passenger.tm_id
JOIN type_de_mission_desc   ON type_de_mission_desc.p_id = passenger.p_id
JOIN passenger_description  ON passenger_description.p_id = passenger.p_id
JOIN users                  ON users.id = passenger.user_id
JOIN users_desc             ON users.user_desc=users_desc.user_desc
JOIN tarif_type             ON tarif_type.tt_id = passenger.tt_id
JOIN option_desc            ON option_desc.p_id = passenger.p_id
JOIN select_an_option_desc  ON select_an_option_desc.p_id = passenger.p_id
JOIN who_give_booking       ON passenger.p_id = who_give_booking.p_id
JOIN passenger_pickup_desc  ON passenger_pickup_desc.p_id = passenger.p_id
JOIN passenger_dropoff_desc ON passenger_dropoff_desc.p_id = passenger.p_id
LEFT JOIN flight_locations pickup  
       ON passenger.pickup_location = pickup.id
LEFT JOIN flight_locations dropoff 
       ON passenger.dropoff_location = dropoff.id
WHERE passenger.p_id =$pid";
      $result = mysqli_query($con,$sql);
      if(mysqli_num_rows($result)==1) {       
          $row=mysqli_fetch_assoc($result);

          $passager_principal=$row['passager_principal'];
          $date_de_prise_en_charge=$row['date_de_prise_en_charge'];
          $Time=$row['Time'];

          $nb_de_passager=$row['nb_de_passager'];
          $user_id=$row['user_id'];
          $users_id=$row['id'];
          $username=$row['username'];
          $phone=$row['phone'];
          $user_desc=$row['user_description'];
          $Vehicule_num=$row['Vehicule_num'];
          $cha_d=$row['chauffeur_desc'];
          $Tarif=$row['Tarif'];
          $type_tt=$row['type_tt'];
          $tm_id=$row['tm_id'];
          $type_m=$row['type_m'];
          $op_tel_desc=$row['op_tel_desc'];
          $op_tel_question=$row['op_tel_question'];
          $type_desc=$row['type_desc'];
          $select_quesntion=$row['select_quesntion'];
          $passenger_select_desc=$row['passenger_select_desc'];
          $passenger_select_quesntion=$row['passenger_select_quesntion'];
          $op_desc=$row['op_desc'];
          $op_question=$row['op_question'];
          $tm_desc=$row['tm_desc'];
          $wg_question=$row['wg_question'];
          $wg_desc=$row['wg_desc'];



    // $pickup_location=$row['pickup_adr'];
    // $dropoff_location=$row['dropoff_adr'];

    // pickup
if ($row['pickup_location'] === 'others') {
    $pickup_location = 'Others';
} else {
    $pickup_location = $row['pickup_adr'];
}

// dropoff
if ($row['dropoff_location'] === 'others') {
    $dropoff_location = 'Others';
} else {
    $dropoff_location = $row['dropoff_adr'];
}

        $ppd_desc     = $row['ppd_desc'];
        $ppd_question = $row['ppd_question'];
        $pdd_desc     = $row['pdd_desc'];
        $pdd_question = $row['pdd_question'];






            
      }
  
  }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PCL100<?php echo $pid;?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
      <!-- Font Awesome -->

      <style>
        .fontSize{
            font-size:12px;
        }
        .fontSize_table{
            font-size:11px;
        }
    


      </style>

  </head>
  <body>
   
  <div class="container" id="myBillingArea">
  <div class="row">
      <div class="col-sm-4"><img src="dist/img/logo_pdf.png" width="100px"></div>
      <div class="col-sm-8 fontSize" style="text-align:right">
          <p>Bon de mission : PCL100<?php echo $pid;?></p>      
      </div>
  </div>
  <div class="row">
      <div class="col-sm-6">
          <p class="h4">PARIS CAB LIMOUSINE</p>
          <ul class="list-unstyled fontSize">
          <li>44 avenue albert Sarraut</li>
          <li>95190 Goussainville</li>
          <li>SIRET : 840056022</li>
          <li>TVA : FR2084056022</li>
          <li>N° EVTC095180698</li>
          <li>Email: pclfacture@gmail.com</li>
          <li>Tél.: +33 660 763 235</li>
          
          </ul>
      </div>

  </div>
  <div class="row">
      <div class="col">
  
      </div>
      <div class="col-5 text-center fontSize">
      Justificatif de réservation préalable
      </div>
      <div class="col">

      </div>
  </div>
  <div class="row">
      <div class="col">
          <hr>
      </div>
  </div>
  <div class="row">
  <div class="col">
                <table class="table table-bordered fontSize_table">
                <tbody>
                    <tr>
                    <th scope="row" >Référence</th>
                    <td>PCL100<?php echo $pid;?></td>
                    </tr>

                    <tr>
                    <th scope="row">Type de mission</th>
                    <td><?php echo $type_m;?> <?php if($tm_id == '4'){ echo '| Hours : ';} ?>
                    <?php 
                    if($tm_id == '4'){  
                    echo $tm_desc;
                    }
                    ?>
                    </td>
                    </tr> 

                    <tr>
                    <th scope="row" style="font-size: 10px; font-weight: bold;">Date de prise en charge</th>
                    <td><?php echo $date_de_prise_en_charge;?> | <?php echo $Time;?></td>
                    </tr> 


                    <?php
                    if ($row['pickup_location'] === 'others') {
                    ?>
                        
                    <?php } else { ?>
                        <tr>
                            <th scope="row"> Pickup Location </th>
                            <td><?php echo nl2br(($pickup_location));?></td>
                        </tr>
                    
                    <?php } ?>



                    <?php if($ppd_question == 'ppdOption'){ ?>
                    <tr>
                    <th scope="row">Adresse du pick-up</th>
                    <td><?php echo htmlspecialchars($ppd_desc);?> </td>
                    </tr>
                    <?php }?>



                    <?php
                    if ($row['dropoff_location'] === 'others') {
                    ?>
                        
                    <?php } else { ?>

                        <tr>
                            <th scope="row">Dropoff Location</th>
                            <td><?php echo nl2br($dropoff_location);?></td>
                        </tr>
                    <?php } ?>



                    <?php if($pdd_question == 'pddOption'){ ?>
                    <tr>
                    <th scope="row">Adresse de dépose</th>
                    <td><?php echo htmlspecialchars($pdd_desc);?> </td>
                    </tr>
                    <?php }?>

                    <tr>
                    <th scope="row">Nb. de passager </th>
                    <td><?php echo $nb_de_passager;?> Passagers</td>
                    </tr>

                    <?php if($passenger_select_quesntion == 'pdesc'){ ?>
                    <tr>
                    <th scope="row">Passenger Description</th>
                    <td><?php echo $passenger_select_desc;?> </td>
                    </tr>
                    <?php }?>

                    <?php if($select_quesntion == 'desc'){ ?>
                    <tr>
                    <th scope="row">Type de mission Desc</th>
                    <td><?php echo $type_desc;?> </td>
                    </tr>
                    <?php }?>


                    
                    <tr>
                    <th scope="row">Passager principal</th>
                    <td><?php echo $passager_principal;?> <?php if($row['op_tel_question'] == 'c_on'){ echo '|';} ?>
                    <?php 
                    if($row['op_tel_question'] == 'c_on'){  
                    echo $op_tel_desc;
                    }
                    ?>
                    </td>
                    </tr>
                    <tr>
                    <th scope="row">Chauffeur</th>
                    <td><?php echo $username;?> | <?php echo $phone;?>
                    <br>
                    <?php echo nl2br($cha_d);?>
                    </td>
                    </tr>
                    <tr>
                    <th scope="row">Véhicule</th>
                    <td><?php echo $Vehicule_num;?></td>
                    </tr>
                    <tr>
                    <th scope="row">Tarif</th>
                    <td>
                        <?php echo '€ '.$Tarif;?> | <?php echo $type_tt;?> 

                    <?php
                    if($users_id == 4){
                        // echo "hi";

                    }else{
                         echo '<br>'.$user_desc;
                    }
                    ?>
                    </td>
                    </tr>

                    <?php if($op_question == 'OnOption'){ ?>
                    <tr>
                    <th scope="row">Options</th>
                    <td><?php echo $op_desc;?> </td>
                    </tr>
                    <?php }?>

                    <?php if($wg_question == 'wgOption'){ ?>
                    <tr>
                    <th scope="row">Booking</th>
                    <td><?php echo $wg_desc;?> </td>
                    </tr>
                    <?php }?>


                </tbody>
                </table>
                </div>
  </div>
  <div class="row">
  <div class="col-sm-12 text-center" >
              <p style="font-size:12px">SERVICE DE VOITURE DE TRANSPORT AVEC CHAUFFEUR <br>
              <span style="font-size:10px">Article R3120-2 du code des transport- Arrêté du 30 juillet 2013</span>
              </p>

             
  </div>
  </div>
</div>



    </body>
</html>
