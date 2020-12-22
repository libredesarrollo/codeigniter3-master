<div class="card post-detail">
    <div class="">
        <?php if ($this->session->userdata('auth_level') >= 9) { ?>
            <a target="_blank" href="<?php echo base_url() ?>admin/post_save/<?php echo $post->post_id ?>">Editar</a>
        <?php } ?>
        <img class="img_responsive" src="<?php echo image_post($post->post_id) ?>" alt="<?php echo $post->title ?>" title="<?php echo $post->title ?>">
    </div>
    <div class="card-body">

        <p class="badge bg-danger badge-danger text-wrap m-0 float-right"><?php echo format_date($post->date) ?></p>
    
        <!--breadcrumb-->
        <div class='mt-1 mb-1' id="breadcrumb">
            <?php echo create_breadcrumb('post', $category, $post) ?>
        </div>

        <?php $this->load->view('blog/utils/ads/rectangulo_largo'); ?>

        <h1><?php echo $post->title ?></h1>

        

        <hr>
        <div class="content-post">
            <?php echo $post->final_content != null ? $post->final_content : $post->content ?>
        </div>
        <div class="col-md-12 mt-3">
            <div class="clearfix">
                <?php foreach ($tags as $tag) : ?>
                    <a class="float-left mr-1 btn btn-sm btn-danger" href="<?php echo base_url() ?>blog/tags/<?php echo $tag->url_clean ?>/<?php echo $tag->tag_id ?>"><?php echo $tag->name; ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php $this->load->view('blog/utils/ads/footer_slide'); ?>

        <?php $this->load->view('blog/utils/freelance/box'); ?>

        <div class="row">
            <div class="col-md-6 offset-md-6">
                <div class="card card">
                    <div class="card-header">
                        Publicidad
                    </div>
                    <?php $this->load->view('blog/utils/ads/cuadrado'); ?>
                </div>
            </div>
        </div>

        <?php if (ENVIRONMENT !== "development") : ?>
            <?php
            if (isset($title)) :
                meta_div($title, $desc, $post->post_id, $url);
            endif;
            ?>
        <?php endif ?>

        <?php $this->load->view('blog/utils/comment') ?>

        <?php $this->load->view('blog/utils/nav_next_back', array('id' => $post->post_id)); ?>

        <script src="<?php echo base_url() ?>assets/js/blog/highlight.pack.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/post_detail.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/blog/monokai_sublime.css">

    </div>

    <?php $this->load->view('blog/utils/modal_css') ?>

    <?php echo $post->web_content; ?>
</div>