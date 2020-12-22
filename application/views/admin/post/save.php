<?php if (isset($post)) : ?>
    <a target="_blank" href="<?php echo base_url() ?>admin/tags/<?php echo $post->post_id ?>"><i class="fa fa-2x fa-tags"></i></a>
    <a target="_blank" href="<?php echo base_url() ?>blog/<?php echo $post->c_url_clean ?>/<?php echo $post->url_clean ?>"><i class="fa fa-2x fa-eye"></i></a>
    <br>
    <br>
<?php endif; ?>



<details class="mb-5">
    <summary>Varios</summary>
    <p>&lt;displayblog data-ids="421,422" data-not-id="50" data-type=&quot;tag|title|ids&quot; data-content=&quot;svg&quot; data-category=&quot;html&quot; data-col=&quot;4&quot; data-limit=&quot;6&quot;&gt;&lt;/displayblog&gt;</p>
    <p>&lt;displayblogd data-col="4" data-ids="421,422" data-type="ids" /&gt;</p>
    <p>&lt;history data-ids="421,422,423,424,425,426,427,428,429,430,431,432,433,434,435"&gt;</p>
    <p>.video-container</p>
    <p>&lt;div class=&quot;history&quot;&gt;<br />
        &lt;ol&gt;<br />
        &nbsp;&nbsp; &nbsp;&lt;li&gt;&lt;a href=&quot;XX&quot;&gt;Test&lt;/a&gt;&lt;/li&gt;<br />
        &nbsp;&nbsp; &nbsp;&lt;li&gt;&lt;a href=&quot;XX&quot;&gt;Test&lt;/a&gt;&lt;/li&gt;<br />
        &lt;/ol&gt;<br />
        &lt;/div&gt;<br />
        &nbsp;</p>
</details>


<?php echo form_open('', 'class="my_form" id="send-post-form" enctype="multipart/form-data"'); ?>
<div class="form-group">
    <?php
    echo form_label('Titulo', 'title');
    ?>
    <?php
    $text_input = array(
        'name' => 'title',
        'minlength' => 10,
        'maxlength' => 165,
        'required' => 'required',
        'id' => 'title',
        'value' => $title,
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>
    <?php echo form_error('title', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Path image', 'path_image');
    ?>
    <?php
    $text_input = array(
        'name' => 'path_image',
        'id' => 'path_image',
        'value' => $path_image,
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>
    <?php echo form_error('url_clean', '<div class="text-danger">', '</div>') ?>

    <span class="mt-1 ml-1 update-path btn btn-primary btn-sm"><i class="fa fa-refresh"></i> Actualizar path img</span>
</div>

<div class="form-group">
    <?php
    echo form_label('Date', 'date');
    ?>
    <?php
    $text_input = array(
        'name' => 'date',
        'id' => 'date',
        'type' => 'date',
        'value' => $date,
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>
    <?php echo form_error('date', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Url limpia', 'url_clean');
    ?>
    <?php
    $text_input = array(
        'name' => 'url_clean',
        'id' => 'url_clean',
        'value' => $url_clean,
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>
    <?php echo form_error('url_clean', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Contenido', 'content');
    ?>
    <?php
    $text_area = array(
        'name' => 'content',
        'id' => 'content',
        'value' => str_replace("<p>&nbsp;</p>", "", $content),
        'class' => 'form-control input-lg',
    );

    echo form_textarea($text_area);
    ?>
    <?php echo form_error('content', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Contenido final', 'final_content');
    ?>
    <?php
    $text_area = array(
        'name' => 'final_content',
        'value' => $final_content,
        'readonly' => 'readonly',
        'class' => 'form-control input-lg final_content',
    );

    echo form_textarea($text_area);
    ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Contenido Web', 'web_content');
    ?>
    <?php
    $text_area = array(
        'name' => 'web_content',
        'id' => 'web_content',
        'value' => str_replace("<p>&nbsp;</p>", "", $web_content),
        'class' => 'form-control input-lg',
    );

    echo form_textarea($text_area);
    ?>
    <?php echo form_error('web_content', '<div class="text-danger">', '</div>') ?>
</div>

<div id="final_content" style="display: none">

</div>

<div class="form-group">
    <?php
    // echo form_label('Raw', 'content');
    ?>
    <?php
    $text_area = array(
        'value' => str_replace("<p>&nbsp;</p>", "", $content),
        'readonly' => 'readonly',
        'class' => 'form-control input-lg',
    );

    //echo form_textarea($text_area);
    ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Descripción', 'description');
    ?>
    <?php
    $text_area = array(
        'name' => 'description',
        'id' => 'description',
        'value' => $description,
        'class' => 'form-control input-lg',
    );

    echo form_textarea($text_area);
    ?>
    <?php echo form_error('description', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Imagen', 'image');
    ?>
    <?php
    $text_input = array(
        'name' => 'upload',
        'id' => 'upload',
        'value' => '',
        'type' => 'file',
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>

    <?php echo isset($post) && $image != "" ? '<img class="img_post img-thumbnail img-presentation-small" src="' . url_main_img($post->post_id) . '#' . random_string('alnum', 5) . '">' : ""; ?>

</div>

<div class="form-group">
    <?php
    echo form_label('Publicado', 'posted');
    echo form_dropdown('posted', $data_posted, $posted, 'class="form-control input-lg"')
    ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Categorias', 'category_id');
    echo form_dropdown('category_id', $categories, $category_id, 'class="form-control input-lg"')
    ?>
</div>

<button class="btn btn-primary" id="send-post">Guardar</button>

<?php echo form_close() ?>



<script>
    $(function() {

        var editor = CKEDITOR.replace('content', {
            height: 400,
            allowedContent: true,
            filebrowserUploadUrl: "<?php echo base_url() ?>admin/upload/<?php echo isset($post) ? $post->post_id : "" ?>/0",
            filebrowserBrowseUrl: "<?php echo base_url() ?>admin/images_server"
        });

        /*editor.on('instanceReady', function(ev) {
            ev.editor.on('paste', function(evt) {
                evt.data.dataValue = evt.data.dataValue.replace(/&nbsp;/g, '');
                evt.data.dataValue = evt.data.dataValue.replace(/<p><\/p>/g, '');
                console.log(evt.data.dataValue);
            }, null, null, 9);
        });*/

        editor.config.autoParagraph = false;

        displayblogdata = [];



        $("#send-post-form").submit(function(event) {
            $("#final_content").html(editor.getData());

            $("#final_content p").each(function() {
                var $this = $(this);
                if ($this.html().replace(/\s|&nbsp;/g, '').length == 0)
                    $this.remove();
            });


            displayBlog();
            displayBlog("displayblogd", 2);
            historyHTML();

            console.log("final")

            //event.preventDefault();

            return;
            //$(".my_form").submit()
        });


        function displayBlog(target = "displayblog", format = "") {
            for (i = 0; i < $("#final_content").find(target).length; i++) {
                var con = $($("#final_content").find(target)[i])

                $.ajax({
                    async: false,
                    url: "<?php echo base_url() ?>admin/post_display_blog/" + format,
                    data: {
                        data_type: con.attr("data-type"),
                        data_content: con.attr("data-content"),
                        data_category: con.attr("data-category"),
                        data_limit: con.attr("data-limit"),
                        data_not_id: con.attr("data-not-id"),
                        data_ids: con.attr("data-ids"),
                        data_col: con.attr("data-col"),
                        data_bound: con.attr("data-bound"),
                    }
                }).done(function(data) {
                    displayblogdata[i] = data;
                    console.log("bloques: " + displayblogdata.length);
                });

            }

            displayblogdata.reverse()

            console.log("__________________________________")

            while (displayblogdata.length > 0) {
                //console.log("quedan bloques: " + displayblogdata.length);
                //console.log($($("#final_content").find("displayblog")[0]).parent("p").html())

                $replace = $($("#final_content").find(target)[0]);
                if ($replace.parent().prop("tagName").toLowerCase() == "p")
                    $replace = $replace.parent()

                $replace.replaceWith(displayblogdata.pop())

                /*if ($($("#final_content").find("displayblog")[0]).parent("p").html() != undefined) {
                 $($("#final_content").find("displayblog")[0]).parent("p").replaceWith(displayblogdata.pop())
                 } else {
                 
                 }*/


            }

            $(".final_content").text($("#final_content").html())
            displayblogdata = [];
        }



        function historyHTML() {
            console.log("Aaaaaaaaaaaaaaaaaaaaaaa")
            var history = $($("#final_content").find("history")[0])

            $.ajax({
                async: false,
                url: "<?php echo base_url() ?>admin/history_blog/",
                data: {
                    ids: history.attr("data-ids")
                }
            }).done(function(data) {
                console.log(data)
                $($("#final_content").find("history")[0]).replaceWith(data);
                $(".final_content").text($("#final_content").html())
            });

        }





        $(".update-path").click(function() {
            $("[name='path_image']").val($("[name='path_image']").val().trim())
            if ($("[name='path_image']").val() == "")
                return;

            $.ajax({
                url: "<?php echo base_url() ?>admin/create_path/",
                data: {
                    path_img: $("[name='path_image']").val(),
                    id: <?php echo isset($post) ? $post->post_id : "''" ?>
                }
            }).done(function(data) {
                noty({
                    text: data,
                    type: "info"
                });
            });
        });


    });
</script>