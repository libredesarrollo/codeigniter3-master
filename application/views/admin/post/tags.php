<div class="main-content">
    <div class="page-content">
        <div class="page-header">
            <h1>
                <a href="<?php echo base_url() ?>admin/post_save/<?php echo $post->post_id ?>" target="_blank"><i class="fa fa-arrow-left"></i></a> Tags
            </h1>
        </div>
        <div>

            <?php echo form_open(''); ?>

            <!-- This contain must be text/plain  -->
            <?php echo form_label('Tags de ' . $post->title, 'my_tags'); ?>
            <div>
                <?php foreach ($my_tags as $tag) { ?>
                    <div class="alert alert-primary">
                        <button class="float-right delete close" data-id="<?php echo $tag->tag_id ?>" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php echo $tag->name; ?>
                    </div>
                <?php } ?>
            </div>

            <div class="form-group">
                <?php echo form_label('Tags', 'tags'); ?>
                <select name="tags" id="tags" style="width:300px" class="form-control">
                    <option value="0">Sin selección</option>
                    <?php foreach ($tags as $tag) { ?>

                        <option value="<?php echo $tag->tag_id ?>"
                                > <?php echo $tag->name; ?> </option>
                            <?php } ?>
                </select>
            </div>

            <?php echo form_close(); ?>

            <?php foreach ($my_tags as $tag) { ?>
                <p>    <?php
                    echo "INSERT INTO post_tag (post_id ,tag_id)VALUES ('$post_id', '$tag->tag_id');";
                    $tag->name;
                    ?> </p>
            <?php } ?>
        </div>
    </div>
</div>


<script>

    $("#tags").change(function () {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>admin/tag_add",
            data: {post_id: <?php echo $post_id; ?>, tag_id: $("#tags").val()}
        }).done(function (msg) {
            //init the select
            //$("#tags").val(0);
            location.reload(true);
        });
    });

    $(".delete").click(function () {

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>admin/tag_remove",
            data: {post_id: <?php echo $post_id; ?>, tag_id: $(this).attr('data-id')}
        }).done(function (msg) {
            location.reload(true);
        });

        //remmove the element to the html
        //$(this).parent().remove();
    });

</script>
<script>
    //$('select').select2()
</script>