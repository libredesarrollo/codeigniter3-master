
<div>
    <div class="box-result box-list clearfix row">
        <?php foreach ($articles as $key => $a) { //iterate all article of category ?>
            <div class="col-md-<?php echo $data_col ?> ">
                <a class="<?php if (isset($a->date_update)) { ?>update <?php } ?>" href="<?php echo url_post_by_id($a->post_id) ?>" >
                    <div class="card mt-2">
                        <img class="w-100" src="<?php echo url_main_img($a->post_id, true, "small"); ?>" alt="<?php echo $a->title; ?>" title="<?php echo $a->title; ?>"/>
                        <hr class="mt-0 mb-0">
                        <div class="card-body">
                            <h5><?php echo $a->title; ?></h5>
                        </div>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</div>