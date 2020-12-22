<!--content-->

<div id="breadcrumb">
    <?php //echo create_breadcrumb_portafolio() ?>
</div>

<h1>Portafolio</h1>
<div class="row">
    <?php foreach ($proyects as $p) { ?>
        <div class="card w-100 mt-3">
            <img src="<?php echo base_url() ?>uploads/portafolio/<?php echo $p->image ?>" class="w-100">
            <div class="card-body">
                <h2><?php echo $p->name ?></h2>
                <p class="m-3"><?php echo $p->description ?></p>
            </div>
        </div>
    <?php } ?>
</div>
