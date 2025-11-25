<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="">JK Software Solution</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-pre
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog" >
	        <div class="modal-content">
	            <div class="modal-body text-center">
	               <h1 class="display-4 text-danger"> <i class="fas fa-trash"></i> </h1>
	                <h1 class="font-weight-lighter">Are you sure?</h1>
	                <h4 class="font-weight-lighter"> Do you really want to delete these records? This process cannot be
                      undone. </h4>       
                <p class="debug-url"></p>
	            </div>
	            <div class="modal-footer">
                  <button type="button btn-primary" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <a class="btn btn-danger btn-ok">Delete</a>
	            </div>
	        </div>
	    </div>
	</div>

  <div class="modal fade" id="confirm-delete-passenger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog" >
	        <div class="modal-content">
	            <div class="modal-body text-center">
	               <h1 class="display-4 text-danger"> <i class="fas fa-trash"></i> </h1>
	                <h1 class="font-weight-lighter">Are you sure?</h1>
	                <h4 class="font-weight-lighter"> Do you really want to delete these records? This process cannot be
                      undone. </h4>       
                <p class="debug-url"></p>
	            </div>
	            <div class="modal-footer">
                  <button type="button btn-primary" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <a class="btn btn-danger btn-ok">Delete</a>
	            </div>
	        </div>
	    </div>
	</div>


</div>
<!-- ./wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>
<script>
      $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
</script>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.minf.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>






<script>
        //delete model driver
$('#confirm-delete').on('show.bs.modal', function(e) {
$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
$('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
});

        //delete model passenger

$('#confirm-delete-passenger').on('show.bs.modal', function(e) {
$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
$('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
});
    </script>
<script>
   $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,"searching": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
   });
   $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    $('.example3').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
        // ⭐ Order by 2nd column (index 1)
  "order": [[1, "asc"]]
    });


    $('.user_view').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });




    
</script>

<script>
  $(function () {


    $('.Type_select').select2({
      theme: 'bootstrap4'
    })

    $('.Chauffeur_select').select2({
      theme: 'bootstrap4'
    })

    $('.Vehicule_select').select2({
      theme: 'bootstrap4'
    })

    $('.companyx').select2({
      theme: 'bootstrap4'
    })


  });

</script>

<!-- <script>
    //Date range picker
    $('#date').datetimepicker({
        format: 'L'
    });
</script> -->
 <!-- x-editable (bootstrap version) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>
<!-- <script type="text/javascript">
  $.fn.editable.defaults.mode = 'inline';
  $('#R101s_<$row['R101s']?>').editable({
    type: 'text',
    pk: <$row['id']?>,
    url: 'process.php',
    title: 'Enter username'
});
</script> -->

<!-- <script>
  $(document).ready(function(){
            $('input[name="EDTextbox1"]').on('click',function(){
                if($(this).val() === 'enabled'){
                    $('#input1').removeAttr('disabled').focus();
                }else{
                    $('#input1').attr('disabled','disabled');
                }
            });
        });
</script> -->
<script>
  // $('.form-group').on('input','.prc',function(){
  //   var totalSum = 0;
  //   $('.form-group .prc').each(function(){
  //     var inputVal = $(this).val();
  //     if($.isNumeric(inputVal)){
  //       totalSum += parseFloat(inputVal);
  //     }
  //   });
  //   $('#o_total_amount').html(totalSum);
  // });

  $('.form-group').on('input','.prc',function(){
 
    var sum= 0;
    $('.form-group .prc').each(function(){
      var num = $(this).val();
      if($.isNumeric(num)){
        sum += parseFloat(num);
      }
    });

    $('#o_total_amount').val(sum);
  });
</script>


<script type="text/javascript">
    function EnableType() {
        var typedesc = document.getElementById("select_quesntion");
        var typedescrib = document.getElementById("typedescrib");
        typedescrib.disabled = typedesc.checked ? false : true;
        typedescrib.value="";
        if (!typedescrib.disabled) {
          typedescrib.focus();
        }
    }

    function EnablePassengerType() {
        var passengerdesc = document.getElementById("passengerdesc");
        var passengerdescrib = document.getElementById("passengerdescrib");
        passengerdescrib.disabled = passengerdesc.checked ? false : true;
        passengerdescrib.value="";
        if (!passengerdescrib.disabled) {
          passengerdescrib.focus();
        }
    }

    function EnableOptions() {
        var Options = document.getElementById("op_question");
        var OptionsEdit = document.getElementById("OptionsEdit");
        OptionsEdit.disabled = Options.checked ? false : true;
        OptionsEdit.value="";
        if (!OptionsEdit.disabled) {
          OptionsEdit.focus();
        }
    }

    function Enable_wgOptions() {
        var wgOptions = document.getElementById("wg_question");
        var Options_wgEdit = document.getElementById("Options_wgEdit");
        Options_wgEdit.disabled = wgOptions.checked ? false : true;
        Options_wgEdit.value="";
        if (!Options_wgEdit.disabled) {
          Options_wgEdit.focus();
        }
    }

    function Enable_ppdOptions() {
        var ppdOptions = document.getElementById("ppd_question");
        var Options_ppdEdit = document.getElementById("Options_ppdEdit");
        Options_ppdEdit.disabled = ppdOptions.checked ? false : true;
        Options_ppdEdit.value="";
        if (!Options_ppdEdit.disabled) {
          Options_ppdEdit.focus();
        }
    }

    function Enable_pddOptions() {
        var pddOptions = document.getElementById("pdd_question");
        var Options_pddEdit = document.getElementById("Options_pddEdit");
        Options_pddEdit.disabled = pddOptions.checked ? false : true;
        Options_pddEdit.value="";
        if (!Options_pddEdit.disabled) {
          Options_pddEdit.focus();
        }
    }

    function EnableCNum() {
        var cnumss = document.getElementById("c_num");
        var typeCnum = document.getElementById("typeCnum");
        typeCnum.disabled = cnumss.checked ? false : true;
        typeCnum.value="";
        if (!typeCnum.disabled) {
          typeCnum.focus();
        }
    }
</script>


<script>
        function showTextBox() {
            document.getElementById('textBox').style.display = 'block';
            document.getElementById('comboBox').style.display = 'none';
              document.getElementById("cnum_on").style.display = "block";
      document.getElementById("cnum_off").style.display = "none";
        }

        function showComboBox() {
            document.getElementById('textBox').style.display = 'none';
            document.getElementById('comboBox').style.display = 'block';
                document.getElementById("cnum_off").style.display = "block";
      document.getElementById("cnum_on").style.display = "none";
        }
</script>

<script>
   // function showTextBox() {
      // document.getElementById("textBox").style.display = "block";
      // document.getElementById("comboBox").style.display = "none";
      // document.getElementById("textBox").disabled = false;

      // document.getElementById("cnum_on").style.display = "block";
      // document.getElementById("cnum_off").style.display = "none";


   // }

   // function showComboBox() {
      // document.getElementById("comboBox").style.display = "block";
      // document.getElementById("textBox").style.display = "none";
      // document.getElementById("textBox").disabled = true;

      // document.getElementById("cnum_off").style.display = "block";
      // document.getElementById("cnum_on").style.display = "none";


    //}
  </script>

    <script>
        //       function showInput() {
        // var radiox = document.getElementById("radio1");
        // var text_input = document.getElementById("text_input");
        // var cnum = document.getElementById("cnum_on");


        // var radioy = document.getElementById("radio2");
        // var combo_box = document.getElementById("combo_box");
        // var cnum_dis = document.getElementById("cnum_off");


        // text_input.style.display  = radiox.checked ? false : true;
        // cnum.style.display  = radiox.checked ? false : true;

        
        // combo_box.style.display  = radioy.checked ? false : true;
        // cnum_dis.style.display  = radioy.checked ? false : true;


        // text_input.value="";
        // combo_box.value="";
        // cnum.value="";
        // cnum_dis.value="";

        // if (!radiox.checked ) {
        //   text_input.style.display = "block";
        //   combo_box.style.display = "none";
        //   // cnum.style.display = "none";
        //   // cnum_dis.style.display = "block";



        // }else if(!radioy.checked ){
        //   text_input.style.display = "none";
        //   combo_box.style.display = "block";
        //   // cnum.style.display = "block";
        //   // cnum_dis.style.display = "none";

        // }
        // }
        // function showInput() {
        //     var radio1 = document.getElementById("radio1");
        //     var radio2 = document.getElementById("radio2");
        //     var textInput = document.getElementById("text-input");
        //     var comboBox = document.getElementById("combo-box");

        //     if (radio1.checked) {
        //       textInput.style.display = "none";
        //         comboBox.style.display = "block";
        //     } else if (radio2.checked) {
          
        //         textInput.style.display = "block";
        //         comboBox.style.display = "none";
        //     }
        // }



    </script>



    <script type="text/javascript">
      function showSelectOption(val){
        var element=document.getElementById('tm_id');
          if(val=='4')
            element.style.display='block';
          else
            element.style.display='none';
      }
    </script>






</body>
</html>
