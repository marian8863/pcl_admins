
<?php
if(isset($_GET['get_id'])){
    $pid=$_GET['get_id'];

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Contacts</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style>
    
  </style>
</head>
<body >
<!-- Site wrapper -->



    <section class="content">
        <div class="card card-solid">
            <div class="row">

                

                <div class="col-md-12">
            
                <table class="table  table-sm">
                    <tr>
                        <td style="border: bottom">
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><img src="dist/img/logo_pdf.png" alt="" width="120px"></li>
                            </ul>
                        </td>
                        <td style="border: bottom 0px;text-align:right">
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><h6 class="lead"><b>Bon de mission :</b> PCL1000{{ get_id }}</h6></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td  style="border: bottom 0px;"> 
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><h2 class="lead"><b>PARIS CAB LIMOUSINE  <?php echo $pid;  ?> </b></h2></li>
                            <li class="small"><b>44 avenue albert Sarraut <br>95190 Goussainville</b></li>
                            <li class="small"><b>SIRET : </b>840056022</li>
                            <li class="small"><b>TVA : </b>FR2084056022</li>
                            <li class="small"><b>N° EVTC : </b>095180698</li>
                            <li class="small"><b>Email: </b>pariscablimo@gmail.com</li>
                            <li class="small"><b>Tél.: </b>+33 660 763 235</li>
                            </ul>
                        </td>
                        <td style="border: bottom 0px;text-align:right"> 
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small">SERVICE DE VOITURE DE TRANSPORT AVEC CHAUFFEUR</li>
                                
                                <li class="small"> Article R3120-2 du code des transport- Arrêté du 30 juillet 2013</li>
                            </ul>
                        </td>

                       
                    </tr>
                    <tr>
                        <td  colspan="2" style="border: bottom 0px;text-align:center">
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><b>JUSTIFICATION DE LA RESERVATION PREALABEL</b></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">

                            <table class="table table-bordered ">
                            <tbody>

                                <tr>
                                    <th>Référence</th>
                                    <td>Réservation PCI1000{{ get_id }}</td>
                                </tr>
                                <tr>
                                    <th>Date de prise en charge</th>
                                    <td>{{ date_de_prise_en_charge }} | {{ Time }}</td>
                                </tr>
                                <tr>
                                    <th>Adresse du pick-up</th>
                                    <td>{{ adresse_du_pick_up }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Adresse de dépose</th>
                                    <td>{{ adresse_de_depose }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nb. de passager</th>
                                    <td>{{ nb_de_passager }} passagers</td>
                                </tr>
                                <tr>
                                    <th>Passager principal</th>
                                    <td>{{ passager_principal }} | {{ contact_number }}</td>
                                </tr>
                                <tr>
                                    <th>Chauffeur</th>
                                    <td>{{ dname }}</td>
                                </tr>
                                <tr>
                                    <th>Véhicule</th>
                                    <td>{{ Vehicule_num }}</td>
                                </tr>
                                <!-- <tr>
                                    <th>Options</th>
                                    <td>{{ op_desc }}</td>
                                </tr> -->
                                <tr>
                                    <th>Tarif</th>
                                    <td>{{ Tarif }} €</td>
                                </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>

                            <!-- <tr>
                                <td colspan="2">
                                    <hr>
                     
                                    <ul class="pagination justify-content-center m-0">
                                    <li class="small">First Plaza, 105, rue de Lourmel 75015 Paris - contact@first-plaza.fr</li>              
                                    </ul>
                   
                                </td>
                            </tr> -->
                </table>
      
                    <!-- /.card -->
                </div>
            </div>

        </div>
    </section>

  </div>
  <!-- /.content-wrapper -->


<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>

