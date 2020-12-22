<?php foreach ($categories as $key => $c) : ?>
    <option value="<?php echo $c->category_id ?>">
        <?php echo $c->name ?>
    </option>
<?php endforeach; ?>
