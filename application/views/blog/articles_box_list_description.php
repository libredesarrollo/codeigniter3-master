<div class="box-result box-list clearfix row">
    <?php foreach ($articles as $key => $a) { //iterate all article of category 
    ?>
        <div class="col-md-<?php echo $data_col ?> ">
            <a class="<?php if (isset($a->date_update)) { ?>update <?php } ?>" href="<?php echo url_post_by_id($a->post_id) ?>">
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="col">
                            <img class="w-100" src="<?php echo url_main_img($a->post_id, true, "small"); ?>" alt="<?php echo $a->title; ?>" title="<?php echo $a->title; ?>" />
                        </div>
                        <div class="col">
                            <h5><?php echo $a->title; ?></h5>
                            <p><?php echo $a->description ?></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
</div>