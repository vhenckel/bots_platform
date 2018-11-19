<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=config_item('titulo-manager');?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>dist/css/font-awesome.min.css?<?=date('is');?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>dist/css/ionicons.min.css">

    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/iCheck/flat/blue.css">
     <!-- Select2 -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/select2/select2.min.css">
    <?php if (isset($morris)) { ?>
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/morris/morris.css">
    <?php } ?>

    <?php if (isset($vectormap)) { ?>
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <?php } ?>


    <?php if (isset($dataTable)) { ?>
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/datatables/dataTables.bootstrap.css">
    <?php } ?>

    <?php if (isset($dateranger)) { ?>
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/daterangepicker/daterangepicker-bs3.css">
    <?php } ?>

    <?php if (isset($wysiwig)) { ?>
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <?php } ?>

     <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>dist/css/AdminLTE.css">

    <?php if (isset($datepicker)) { ?>
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/bootstrap-timepicker.min.css">
    <?php } ?>

    <?php if (isset($colorpicker)) { ?>
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/colorpicker/bootstrap-colorpicker.min.css">
    <?php } ?>
    <?php if (isset($icheck)) { ?>
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/iCheck/all.css">
    <?php } ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="icon" href="<?=base_url() . 'assetsAdmin/';?>dist/img/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?=base_url() . 'assetsAdmin/';?>dist/img/favicon.ico" type="image/x-icon" />
    <script async type="text/javascript">

      var ROOT = "<?=base_url();?>";
      var LANG = "PT";
      var SISTEMA_MODELO_ID = "";
      var URL_FORM_AJAX = "<?=base_url();?>";
      var CONVERSION_ID = "00000";
      var CONVERSION_LABEL = "xxxxxx";

      </script>

  </head>
  <body class="hold-transition skin-black sidebar-mini">
  <div class="wrapper">
      <header class="main-header">
          <!-- Logo -->
          <a href="<?=base_url() . 'manager/dashboard/';?>" class="logo" alt="<?=config_item('titulo-manager');?>" title="<?=config_item('titulo-manager');?>">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"> <img src="<?=config_item('icone-lf');?>" class="img" alt="<?=config_item('sistema');?>" width="40">
              </span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg"><img src="<?=config_item('logo-lf');?>" width="190px">
              </span>
          </a>
          <!-- Header Navbar: style can be found in header.less -->
          <nav class="navbar navbar-static-top" role="navigation">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                  <span class="sr-only">Toggle navigation</span>
              </a>
              <div class="navbar-custom-menu">
                  <ul class="nav navbar-nav">


                      <!-- User Account: style can be found in dropdown.less -->
                      <li class="dropdown user user-menu">
                          <a href="" class="dropdown-toggle" data-toggle="dropdown">
                              <img src="<?=config_item('icone-lf');?>" class="user-image" alt="<?=config_item('sistema');?>">
                              <span class="hidden-xs"><?=config_item('sistema');?></span>
                          </a>
                          <ul class="dropdown-menu">
                              <!-- <?=config_item('sistema');?> -->
                              <li class="user-header">
                                  <img src="<?=config_item('icone-lf');?>" class="img-circle" alt="<?=config_item('sistema');?>">
                                  <p>
                                      <?=config_item('sistema');?>
                                      <small>IP: <?=config_item('IP');?></small>
                                  </p>
                              </li>
                              <!-- Menu Footer-->
                              <li class="user-footer">
                                  <div class="pull-right">
                                      <a href="<?=base_url() . 'manager/logout';?>" class="btn btn-default btn-flat">SAIR</a>
                                  </div>
                              </li>
                          </ul>
                      </li>
                  </ul>
              </div>

          </nav>
      </header>