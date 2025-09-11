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
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">jsGrid</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <div class="row" style="text-align:center;">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:left;!important">
            <table>
                <tr>
                    <th>
                       <!-- <img src="imag/logo-dark.png" alt="" width="200px"> -->
                    </th>
                </tr>
                <tr>
                    <th>
                        Planning : +33 158 625 747
                    </th>
                </tr>
                <tr>
                    <td>
                        Mission saisie le 29/09/2023 à 10h53
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" >
            <table class="table table-bordered" style="margin-bottom: 3rem" >

                <tr>
                <th colspan="3" class="table-active">Fiche de mission</th>
                </tr>

                <tr>
                <th class="table-active">N° de dossier</th>
                <th class="table-active">N° de mission</th>
                <th class="table-active">N° de version</th>
                </tr>

                <tr>
                <td>87696</td>
                <td>1</td>
                <td>1</td>
                </tr>

            </table>
        </div>

        <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table class="table table-bordered" style="margin-bottom: 5rem" >

                <tr>
                <th class="table-active">Date</th>
                <th class="table-active">Client</th>
                <th colspan="3" class="table-active">Chauffeur</th>
                </tr>

                <tr>
                <td>30 septembre 2023</td>
                <td>Hôtel JK Place</td>
                <td  colspan="3">Arumainayagam Norton Alex +33 6 60 76 32 35
                    <!-- <table class="table table-bordered" >

                    <tr>
                        <th class="table-active">Catégorie</th>
                        <td>Minivan</td>
                        <th class="table-active">Véhicule</th>
                        <td></td>
                    </tr>

                    </table> -->
                </td>
                </tr>

                <tr>
                <th class="table-active "  >Hôte : Pax 2</th>
                <th class="table-active">Référence</th>
                <th  colspan="3" class="table-active">Note au chauffeur</th>
                </tr>

                <tr  style="height: 150px;">
                <td>Mr Mazzarella Antdony +1 908 812 5468</td>
                <td>MSN</td>
                <td  colspan="3"></td>
                </tr>

                <tr>
                <th colspan="5" class="table-active">Prise en charge</th>
                </tr>

                <tr style="height: 80px;">
                <th><h1>10:00</h1></th>
                <td  colspan="4">JK Place Paris 82 Rue de Lille, 75007 Paris, Tél 01 40 60 40 20</td>
                </tr>

                <tr>
                <th colspan="5" class="table-active">Itinéraire</th>
                </tr>

                <tr style="height: 150px;">
                <td colspan="5"></td>
                </tr>

                <tr>
                <th colspan="5" class="table-active">Fin de service</th>
                </tr>

                <tr style="height: 80px;">
                <td  colspan="4">CDG1 , Roissy-en-France, France , vol UA55 , Terminal 1, Newark à 13h10</td>
                <th><h1>11:00</h1></th>
                </tr>

                <tr>
                <th colspan="5" class="table-active">Informations obligatoires à compléter</th>
                </tr>

                <tr>
                <td class="table-light">Heure départ garage</td>
                <td class="table-light">Heure retour garage</td>
                <td class="table-light">Km départ</td>
                <td class="table-light">Km arrivée</td>
                <td class="table-light">TOTAL km</td>
                </tr>

                <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>


            </table>

            <hr>

            <p>First Plaza, 105, rue de Lourmel 75015 Paris - contact@first-plaza.fr</p>
        </div>
    </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
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