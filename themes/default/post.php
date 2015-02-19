<h1><?php echo $post->title; ?></h1>

<div class="meta">
    Posted <?php echo $post->date->format("Y-m-d"); ?>
</div>
<div class="page">
    <?php echo $post->body; ?>
</div>
