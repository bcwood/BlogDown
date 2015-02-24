<?php
require_once("includes/config.php");

function blogdown_init()
{
    require_once("includes/classes/Post.php");
    
    $theme_path = "themes/" . THEME;

    if (isset($_GET["post"]))
    {
        $date = $_GET["y"] . "-" . $_GET["m"] . "-" . $_GET["d"];
        $path = "content/posts/$date-" . $_GET["post"] . ".md";
        $post = new Post($path);

        render($post);
    }
    else if (isset($_GET["page"]))
    {
        $path = "content/pages/" . $_GET["page"] . ".md";
        $post = new Post($path);

        render($post);
    }
    else
    {
        $files = glob("content/posts/*.md");
        rsort($files);

        $posts = array();        
        $HOME_PAGE_ENTRIES = 10;
        $count = 1;

        foreach ($files as $file) 
        {
            //echo "$file <br>";
            $post = new Post($file);

            // filter out future and unpublished posts
            if ($post->date > new DateTime() || !$post->published)
                continue;

            $posts[] = $post;

            $count++;
            if ($count > $HOME_PAGE_ENTRIES)
                break;
        }

        render($posts);
    }
}

function render($post)
{
    $theme_path = "themes/" . THEME;
    
    // this feels hacky
    // TODO: always pass an array of posts, and implement the_post() similar to wordpress?
    if (is_array($post))
    {
        $posts = $post;
        $type = "index";
    }
    else
    {
        if ($post->date > new DateTime())
            die("Future post is not yet visible.");
        if (!$post->published)
            die("Post has not been published yet.");
        
        $type = $post->type;   
    }
    
    include("$theme_path/header.php");
    include("$theme_path/$type.php");
    include("$theme_path/footer.php");   
}

function the_title()
{
    $title = BLOG_TITLE;
    
    global $post;
    
    if (isset($post))
    {
        $title = "$post->title - $title";
    }
    
    return $title;
}
?>