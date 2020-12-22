<div class="card post-detail">
    <div class="card-body">

        <h1><?php echo $category->name; ?></h1>
        <hr>

        <?php echo $category->body; ?>

        <script src="<?php echo base_url() ?>assets/js/blog/highlight.pack.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/post_detail.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/blog/monokai_sublime.css">

    </div>
    <div class="card-footer">
    <a target="blank" href="/blog/<?php echo $category->url_clean; ?>/1">Ver Listado &#187;</a>
    </div>
</div>