<?php

if (!file_exists("includes/config.php"))
{
    header("Location: install.php");
    exit();
}

require_once("includes/config.php");
require_once("includes/core.php");
require_once("includes/parser.php");

$theme_path = "themes/" . THEME;

if (isset($_GET["post"]))
{
    $date = $_GET["y"] . "-" . $_GET["m"] . "-" . $_GET["d"];
    $path = "content/posts/$date-" . $_GET["post"] . ".md";
    $post = parseMarkdownFile($path);
    //$post->date = new DateTime($date);

    if ($post->date > new DateTime())
        die("Future post is not yet visible.");
    if (property_exists($post, "published") && strtolower($post->published == "false"))
        die("Post has not been published yet.");

    include("$theme_path/header.php");
    include("$theme_path/post.php");
}
else if (isset($_GET["page"]))
{
    $path = "content/pages/" . $_GET["page"] . ".md";
    $post = parseMarkdownFile($path);

    if (property_exists($post, "published") && strtolower($post->published == "false"))
        die("Page has not been published yet.");

    include("$theme_path/header.php");
    include("$theme_path/page.php");
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
        $posts[] = parseMarkdownFile($file);        
        
        $count++;
        if ($count > $HOME_PAGE_ENTRIES)
            break;
    }

    include("$theme_path/header.php");
    include("$theme_path/index.php");
}

include("$theme_path/footer.php");

?>
