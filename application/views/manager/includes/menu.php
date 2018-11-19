<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?=config_item('icone-lf');?>" class="img-circle" alt="<?=config_item('sistema');?>">
            </div>
            <div class="pull-left info">
                <p><?=$this->session->userdata('nome');?></p>
                <a href="#"> <i class="fa fa-circle text-success"></i>
                    Online
                </a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">OPÇÕES</li>
            <li class="<?php if($menu == 'dashboard') echo 'active';?>">
                <a href="<?=base_url() . 'manager/dashboard/';?>">
                    <i class="fa fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview <?php if($menu == 'chatbot') echo 'active';?>">
              <a href="#"> <i class="fa fa-android"></i>
                  <span>ChatBots</span>
                  <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                   <li  class="<?php if($submenu == 'novo') echo 'active';?>">
                      <a href="<?=base_url() . 'manager/chatbots/adicionar';?>">
                          <i class="fa fa-circle-o"></i>
                          Criar novo
                      </a>
                  </li>
                   <li  class="<?php if($submenu == 'listar') echo 'active';?>">
                      <a href="<?=base_url() . 'manager/chatbots';?>">
                          <i class="fa fa-circle-o"></i>
                          Listar
                      </a>
                  </li>
              </ul>
            </li>
            <li class="treeview <?php if($menu == 'dialogos') echo 'active';?>">
              <a href="#"> <i class="fa fa-comments-o"></i>
                  <span>Diálogos</span>
                  <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i>
                  </span>
              </a>
              <ul class="treeview-menu">
                   <li  class="<?php if($submenu == 'novo') echo 'active';?>">
                      <a href="<?=base_url() . 'manager/dialogos/novo';?>">
                          <i class="fa fa-circle-o"></i>
                          Novo
                      </a>
                  </li>
                  <li  class="<?php if($submenu == 'templates') echo 'active';?>">
                      <a href="<?=base_url() . 'manager/dialogos/templates';?>">
                          <i class="fa fa-circle-o"></i>
                          Templates
                      </a>
                  </li>
              </ul>
            </li>
            <li class="<?php if($menu == 'segmentos') echo 'active';?>">
                <a href="<?=base_url() . 'manager/segmentos/';?>">
                    <i class="fa fa-tag"></i>
                    <span>Segmentos</span>
                </a>
            </li>
            <li class="<?php if($menu == 'usuarios') echo 'active';?>">
                <a href="<?=base_url() . 'manager/usuarios/';?>">
                    <i class="fa fa-group"></i>
                    <span>Usuários</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>