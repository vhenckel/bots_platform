<!-- INICIO CONTEUDO -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small>Painel de Controle</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?=base_url() . 'manager/dashboard';?>"> <i class="fa fa-dashboard"></i>
                    Home
                </a>
            </li>
            <li class="active"><?=$title;?></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('success')) { ?>
        <div class="row" id="alerta-superior">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4> <i class="icon fa fa-check"></i> Sucesso! </h4> <?=$this->session->flashdata('success');?>
                </div>
            </div>
        </div>
        <?php
        }
        if ($this->session->flashdata('danger')) {
        ?>
        <div class="row" id="alerta-superior">
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4> <i class="icon fa fa-ban"></i> Erro! </h4> <?=$this->session->flashdata('danger');?>
                </div>
            </div>
        </div>
        <?php } ?>