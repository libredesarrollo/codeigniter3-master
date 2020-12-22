<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- sidebar: style can be found in sidebar.less -->

    <a href="../../index3.html" class="brand-link">
        <img src="<?php echo base_url() ?>assets/img/logo.png" alt="DL" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo $this->session->userdata('name') ?></span>
    </a>



    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Portafolio
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/jobs_crud/add" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Crear</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/jobs_crud" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Listar</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Cursos
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/courses_crud/add" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Crear</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/courses_crud" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Listar</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Usuarios
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/user_crud/add" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Crear</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/user_crud" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Listar</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Post
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/post_save/add" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Crear</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/post_list" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Listar</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Categorías
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/category_crud/add" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Crear</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/category_crud" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Listar</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Tags
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/tag_crud/add" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Crear</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/tag_crud" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Listar</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Contactos
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>admin/contact" class="nav-link">
                            <i class="fa fa-circle-o"></i>
                            <p>Ver</p>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
    
</aside>