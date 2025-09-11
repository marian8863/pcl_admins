
<?php
include '../config.php';

if(isset($_GET['get_id'])){
    $pid=$_GET['get_id'];
    $sql="SELECT 
    passenger.passager_principal,
    passenger.date_de_prise_en_charge,
    passenger.Time,
    passenger.adresse_du_pick_up,
    passenger.adresse_de_depose,
    passenger.nb_de_passager,
    passenger.d_id,
    passenger.chauffeur_desc,
    driver.dname,
    driver.dtp_num,
    driver.driver_desc,
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
    who_give_booking.wg_question

    FROM passenger,option_tel,vehicule,type_mission,type_de_mission_desc,passenger_description,driver,tarif_type,option_desc,select_an_option_desc,who_give_booking
    WHERE passenger.p_id=option_tel.p_id and vehicule.v_id=passenger.Vehicule_num and type_mission.tm_id=passenger.tm_id and type_de_mission_desc.p_id=passenger.p_id and passenger_description.p_id=passenger.p_id and driver.d_id=passenger.d_id and tarif_type.tt_id=passenger.tt_id and option_desc.p_id=passenger.p_id and select_an_option_desc.p_id=passenger.p_id and passenger.p_id=who_give_booking.p_id 
    
    and passenger.p_id=$pid";
      $result = mysqli_query($con,$sql);
      if(mysqli_num_rows($result)==1) {       
          $row=mysqli_fetch_assoc($result);

          $passager_principal=$row['passager_principal'];
          $date_de_prise_en_charge=$row['date_de_prise_en_charge'];
          $Time=$row['Time'];
          $adresse_du_pick_up=$row['adresse_du_pick_up'];
          $adresse_de_depose=$row['adresse_de_depose'];
          $nb_de_passager=$row['nb_de_passager'];
          $d_id=$row['d_id'];
          $dname=$row['dname'];
          $dtp_num=$row['dtp_num'];
          $driver_desc=$row['driver_desc'];
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
    
  td {
    white-space: pre-wrap;
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
          <li>Email: pariscablimo@gmail.com</li>
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
                    <th scope="row">Référence</th>
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
                    <th scope="row">Date de prise en charge</th>
                    <td><?php echo $date_de_prise_en_charge;?> | <?php echo $Time;?></td>
                    </tr> 

                    <tr>
                    <th scope="row">Adresse du pick-up </th>
                    <td><?php echo nl2br(htmlspecialchars($adresse_du_pick_up));?></td>
                    </tr>
                    <tr>
                    <th scope="row">Adresse de dépose</th>
                    <td><?php echo $adresse_de_depose;?></td>
                    </tr>
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
                    <td><?php echo $dname;?> | <?php echo $dtp_num;?>
                    <br>
                    <?php echo $cha_d;?>
                    </td>
                    </tr>
                    <tr>
                    <th scope="row">Véhicule</th>
                    <td><?php echo $Vehicule_num;?></td>
                    </tr>
                    <tr>
                    <th scope="row">Tarif</th>
                    <td><?php echo '€ '.$Tarif;?> | <?php echo $type_tt;?> 

                    <?php
                    if($driver_desc == 'no_desc'){
                        // echo "hi";

                    }else{
                         echo '<br> <br>'.$driver_desc;
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
