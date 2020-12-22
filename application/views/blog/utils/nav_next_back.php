<?php
$past = create_past_article($id);
$next = create_next_article($id);
?>

<nav class="navigation mt-1">
    <?php if (isset($past['title'])) { ?>
        <a href="<?php echo $past['href']; ?>" class="float-left">
            &#171;
            <?php echo $past['title']; ?>
        </a>
    <?php } ?>

    <?php if (isset($next['title'])) { ?>
        <a href="<?php echo $next['href']; ?>" class="float-right">
            <?php echo $next['title']; ?>
            &#187;
        </a>
    <?php } ?>
</nav>