

<?php if ($cources): ?>
    <div id="open-modal" class="modal-window">
        <div>
            <a href="#" title="Close" class="modal-close">Close</a>
            <h1>Cursos relacionados</h1>

            <?php foreach ($cources as $key => $c) : ?>
                <div>
                    <h5><?php echo $c->name ?></h5>
                    <img src="<?php echo base_url() ?>uploads/course/<?php echo $c->image ?>" class="w-100">
                    <p><?php echo $c->description ?></p>
                    <div class="clearfix">
                        <a target="_blank" href="<?php echo base_url() . 'blog/' . $c->c_url_clean . '/' . $c->url_clean ?>" class="btn btn-danger float-right">Tomar el curso</a>
                    </div>
                    <hr>
                </div>
            <?php endforeach ?>

        </div>
    </div>
<?php endif; ?>