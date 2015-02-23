<h1><?php echo $post->title; ?></h1>

<div class="post-meta">
    Posted <?php echo $post->date->format("Y-m-d"); ?>
</div>
<div class="post">
    <?php echo $post->body; ?>
</div>
