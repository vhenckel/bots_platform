    </section>
</div>
<footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Versão</b> <?=config_item('versao');?>
        </div>
        Copyright &copy; <?=date('Y');?> <strong><?=config_item('sistema');?></strong>
      </footer>

      </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/jQueryUI/jquery-ui.min.js"></script>

    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=base_url() . 'assetsAdmin/';?>bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/select2/select2.full.min.js"></script>

    <?php if (isset($morris)) { ?>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/morris/morris.min.js"></script>
    <?php } ?>

    <?php if (isset($sparkline)) { ?>
    <!-- Sparkline -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/sparkline/jquery.sparkline.min.js"></script>
    <?php } ?>

    <?php if (isset($vectormap)) { ?>
    <!-- jvectormap -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <?php } ?>

    <?php if (isset($knobchart)) { ?>
    <!-- jQuery Knob Chart -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/knob/jquery.knob.js"></script>
    <?php } ?>

    <?php if (isset($dateranger)) { ?>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/daterangepicker/daterangepicker.js"></script>
    <?php } ?>

    <?php if (isset($datepicker)) { ?>
    <!-- InputMask -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- datepicker -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/datepicker/bootstrap-datepicker.js"></script>
     <!-- bootstrap time picker -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- FastClick -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/fastclick/fastclick.min.js"></script>
    <?php } ?>

    <?php if (isset($colorpicker)) { ?>
    <!-- bootstrap color picker -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script>
        $(function () {
            //color picker with addon
            $(".my-colorpicker2").colorpicker();
        } );
    </script>
    <?php } ?>
    <!-- Slimscroll -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=base_url() . 'assetsAdmin/';?>dist/js/app.min.js"></script>

    <?php if (isset($dataTable)) { ?>
    <!-- DataTables -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
      $(function () {
        $('#listaDataTable').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
    </script>
    <?php } ?>

    <?php if (isset($wysiwig)) { ?>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
      $(function () {
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
        $(".textareaCabecalho").wysihtml5({
        toolbar: {
            "font-styles": false, // Font styling, e.g. h1, h2, etc.
            "emphasis": true, // Italics, bold, etc.
            "lists": false, // (Un)ordered lists, e.g. Bullets, Numbers.
            "html": false, // Button which allows you to edit the generated HTML.
            "link": false, // Button to insert a link.
            "image": false, // Button to insert an image.
            "color": false, // Button to change color of font
            "blockquote": false, // Blockquote
          }
    });
      });
    </script>
    <?php } ?>
    <?php if (isset($icheck)) { ?>
    <!-- iCheck 1.0.1 -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/iCheck/icheck.min.js"></script>
    <script>
        //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
    </script>
    <?php } ?>
    <?php if (isset($mask)) { ?>
    <script src="<?=base_url() . 'assets/';?>plugins/jquery_mask/jquery.mask.min.js"></script>
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/input-mask/jquery.inputmask.phone.extensions.js"></script>
    <script>
        $(document).ready(function(){
          $('#telefone').mask('(99)99999-9999');
          console.log($('#telefone').val);
          //Initialize Select2 Elements
            $(".select2").select2();
        });
    </script>
    <?php } ?>
    <script src="<?=base_url() . 'assetsAdmin/';?>dist/js/function.js?<?=date('is');?>"></script>
    <script>
        $(document).ready(function(){
          //Initialize Select2 Elements
            $(".select2").select2({
              maximumSelectionLength: 1
            });
        });
    </script>
  </body>
</html>
