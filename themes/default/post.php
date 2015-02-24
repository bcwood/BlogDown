<div class="entry post">
    <h1><?php echo $post->title; ?></h1>

    <div class="entry-meta">
        Posted <?php echo $post->date->format("Y-m-d"); ?>
    </div>
    <div class="entry-body">
        <?php echo $post->body; ?>
    </div>
</div>
