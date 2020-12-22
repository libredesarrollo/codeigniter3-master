<ol class="breadcrumb float-sm-right">
    <?php foreach ($breadcrumb as $key => $li) : ?>
        <li><a class="breadcrumb-item" href="<?php echo base_url() . $li[0] ?>"> <?php echo $li[1] ?></a></li>
    <?php endforeach ?>
</ol>