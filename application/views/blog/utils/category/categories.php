<div class="row">
    <?php foreach ($categories as $key => $c) : ?>
        <div class="col-md-3 col-xs-6">
            <a class="dropdown-item" href="<?php echo base_url() . 'blog/' . $c->url_clean ?>">
                <img class="w-100 img-thumbnail " src="<?php echo image_category($c->url_clean) ?>" alt="<?php echo $c->name ?>" title="<?php echo $c->name ?>">

                <h5 class="text-center"><?php echo $c->name ?></h5>
            </a>
        </div>
    <?php endforeach; ?>
</div>
