<div class="history">
    <ol>
        <?php foreach ($articles as $key => $a) : ?>
            <li><a target="blank" href="<?php echo url_post_by_id($a->post_id) ?>"><?php echo $a->title ?></a></li>
        <?php endforeach ?>
    </ol>
</div>