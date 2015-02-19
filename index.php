<?php

if (!file_exists("core/git-config.php"))
{
    header("Location: install.php");
    exit();
}

require_once("core/config.php");
require_once("core/parser.php");

$theme_path = "themes/" . THEME;

if (isset($_GET["post"]))
{
    $date = $_GET["y"] . "-" . $_GET["m"] . "-" . $_GET["d"];
    $path = "content/posts/$date-" . $_GET["post"] . ".md";
    global $post;
    $post = parseMarkdownFile($path);
    $post->date = new DateTime($date);

    if ($post->date > new DateTime())
        die("Future post is not yet visible.");
    if (strtolower($post->published == "false"))
        die("Post has not been published yet.");

    include("$theme_path/header.php");
    include("$theme_path/post.php");
}
else if (isset($_GET["page"]))
{
    $path = "content/pages/" . $_GET["page"] . ".md";
    global $post;
    $post = parseMarkdownFile($path);

    if (strtolower($post->published == "false"))
        die("Page has not been published yet.");

    include("$theme_path/header.php");
    include("$theme_path/page.php");
}
else
{
    // TODO: generate home page
    include("$theme_path/header.php");
    include("$theme_path/index.php");
}

include("$theme_path/footer.php");

?>
