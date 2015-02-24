<ol class="entry-list">
    <?php foreach ($posts as $post) : ?>        
        <li>
            <div class="entry-meta"><?php echo $post->date->format("j M Y"); ?></div>
            <h2><a href="<?php echo $post->permalink; ?>"><?php echo $post->title; ?></a></h2>
        </li>
    <?php endforeach; ?>
</ol>