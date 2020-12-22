

<footer class="main-footer">

    <?php $this->load->view("blog/utils/follows_links"); ?>

    <div class="hidden-xs text-center">
        <?php echo '<b>' . APP_NAME . '</b> Versión ' . APP_VERSION; ?>
        <br>
        <a href="<?php echo base_url() ?>acerca-de">Acerca de</a> | 
        <a href="<?php echo base_url() ?>contacto">Contacto</a>
    </div>
    
</footer>   