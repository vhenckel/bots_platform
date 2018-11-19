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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=base_url() . 'assetsAdmin/';?>plugins/iCheck/square/blue.css">
    <link rel="shortcut icon" href="<?=base_url() . 'assetsAdmin/';?>dist/img/favicon.ico" type="image/x-icon" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <?php
        if ($this->session->flashdata('danger')) {
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4> <i class="icon fa fa-ban"></i>
                        Erro!
                    </h4>
                    <?=$this->session->flashdata('danger');?>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="login-logo">
            <a href="<?=base_url() . 'manager/login';?>" alt="<?=config_item('titulo-manager');?>" title="<?=config_item('titulo-manager');?>">
                <img src="<?=config_item('logo-lf');?>" alt="<?=config_item('cliente');?>">
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Logar</p>
            <form action="<?=base_url() . 'manager/logar';?>" method="post">
                <div class="form-group has-feedback">
                    <input type="user" name="user" class="form-control" placeholder="Usuário">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Logar</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=base_url() . 'assetsAdmin/';?>bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?=base_url() . 'assetsAdmin/';?>plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
</body>
</html>