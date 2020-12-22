<!--content-->

<div id="breadcrumb">
    <?php //echo create_breadcrumb_portafolio() ?>
</div>

<h1>Cursos</h1>
<div class="row">
    <?php foreach ($courses as $p) { ?>
        <div class="col-md-6">
            <div class="card w-100 mt-3">
                <a target="_blank" href="<?php echo base_url() . 'blog/' . $p->c_url_clean . '/' . $p->url_clean ?>">
                    <img src="<?php echo base_url() ?>uploads/course/<?php echo $p->image ?>" class="w-100">
                    <div class="card-body">
                        <h2><?php echo $p->name ?></h2>
                        <p class="m-3"><?php echo $p->description ?></p>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
</div>
