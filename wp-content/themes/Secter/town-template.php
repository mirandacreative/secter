<div class="towns-of-SC">
    <h2>TOWNS OF SOUTHEASTERN CONNECTICUT</h2>
    <div class="map">
        <?php $data = unserialize(get_option('map-for-secter')); ?>
        <img src="<?php echo $data['background-img']; ?>">
        <?php foreach ($data['title-city'] as $key => $value): ?>
            <a href="<?php echo $data['link-city'][$key] ?>" class="link-town"
               style="position: absolute; top: <?php echo $data['top_in_proc'][$key] ?>%; left: <?php echo $data['left_in_proc'][$key] ?>%;"><?php echo $value; ?></a>
        <?php endforeach; ?>
    </div>
</div>