<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo base_url()  ?>">
            <img style="max-width: 45px;" class="logo" src="<?php echo base_url() . 'assets/img/logo.png' ?>" alt="Logo Desarrollo Libre" title="Logo Desarrollo Libre">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php $this->load->view("blog/template/menu") ?>
            <div class="form-inline my-2 my-lg-0" id="search-results">
                <div class="input-group mb-3 pt-3">
                    <select id="list-categories">
                        <option value="">Categoria</option>
                        <?php $this->load->view("blog/utils/category_list", array("categories" => get_all_categories())) ?>
                    </select>
                    <input type="text" class="form-control" id="input-search-post" placeholder="Buscar...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" id="btn-search-post" type="button">Buscar</button>
                    </div>
                </div>
            </div>
            <ul class="nav navbar-nav navbar-right user-options">
                <?php if ($this->session->userdata("id") != NULL) : ?>
                    <li title="Perfil">
                        <a href="<?php echo base_url() . 'app/profile' ?>">
                            <span class="fa fa-user"></span>
                        </a>
                    </li>
                    <li title="Cerrar Sesión">
                        <a href="<?php echo base_url() . 'app/logout' ?>">
                            <span class="fa fa-sign-out"></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>