<?php foreach ($posts as $key => $p) : ?>
    <div class="card post">

        <a href="<?php echo base_url() . 'blog/' . $p->c_url_clean . '/' . $p->url_clean ?>">
        <img src="<?php echo image_post($p->post_id) ?>">
            <div class="card-body">
                
                <p class="badge bg-danger badge-danger text-wrap mb-0"><?php echo format_date($p->date) ?></p>
                <h3><?php echo $p->title ?></h3>
                <p class="font-weight-light ml-2"><?php echo $p->description ?></p>
            </div>
        </a>
    </div>
    <br>
<?php endforeach; ?>

<?php
if ($pagination) :

    $prev = $current_page - 1;
    $next = $current_page + 1;

    if ($prev < 1)
        $prev = 1;

    if ($next > $last_page)
        $next = $last_page;
?>

    <ul class="pagination">
        <?php for ($i = 1; $i <= $last_page; $i++) { ?>
            <li class="page-link"><a href="<?php echo base_url() . $token_url . $i; ?> "> <?php echo $i; ?></a></li>
        <?php } ?>
    </ul>
<?php endif; ?>