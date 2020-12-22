<!DOCTYPE html>
<html lang="es">

<head>


    <?php
    if (isset($title)) :
        meta_tags($title, $desc, $imgurl, $url);
    ?>
        <title><?php echo APP_NAME . ' | ' . $title ?></title>
    <?php else :
    ?>
        <title><?php echo APP_NAME . ' | ' . APP_DESCRIPTION ?></title>
    <?php
    endif;
    ?>

    <?php if (isset($schema)) : ?>
        {schema}
    <?php endif; ?>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
    <script data-ad-client="ca-pub-5280469223132298" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="article:section" content="Artículos de desarrollo de software" />

    <link rel="author" href="https://plus.google.com/100141040904926928047" />
    <link rel="publisher" href="https://plus.google.com/100141040904926928047" />
    <link rel="alternate" title="Soy Andrés Cruz y este es mi RSS con los últimas entradas del blog." href="<?php echo base_url() ?>blog/rss" type="application/rss+xml">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>


    <script>
        var BASE_URL = "<?php echo base_url() ?>";
    </script>
    <script>
        var ENVIRONMENT = "<?php echo ENVIRONMENT ?>";
    </script>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <?php $this->load->view("blog/template/header"); ?>
    <section class="container">
        <div id="post_search"></div>
        {body}
    </section>

    <?php $this->load->view("blog/template/footer"); ?>

    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/blog/main.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/blog/custom.css">

    <?php if (ENVIRONMENT !== "development") : ?>
        <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51f317ce02473ae1"></script>
        ?>
    <?php endif ?>

    <?php if ($this->session->flashdata("text") != null) : ?>
        <script>
            $.toaster({
                priority: '<?php echo $this->session->flashdata("type") ?>',
                title: '<?php echo $this->session->flashdata("text") ?>',
                message: ''
            });
        </script>
    <?php endif; ?>



</body>

</html>