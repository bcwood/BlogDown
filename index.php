<?php

if (!file_exists("core/git-config.php"))
{
    header("Location: install.php");
    exit();
}

require_once("core/config.php");
require_once("core/Parsedown.php");

$theme_path = "themes/" . THEME;

include("$theme_path/header.php");

if (isset($_GET["post"]))
{
    $path = "content/posts/" . $_GET["y"] . "-" . $_GET["m"] . "-" . $_GET["d"] . "_" . $_GET["post"] . ".md";
    echo parseMarkdownFile($path);
}
else if (isset($_GET["page"]))
{
    $path = "content/pages/" . $_GET["page"] . ".md";
    echo parseMarkdownFile($path);
}
else
{
    // TODO: generate home page
    include("$theme_path/index.php");
}

include("$theme_path/footer.php");

function parseMarkdownFile($path)
{
    if (!file_exists($path))
    {
        http_response_code(404);
        $path = "content/pages/404.md";
    }

    $markdown = file_get_contents($path);
    $parsedown = new Parsedown();
    return $parsedown->text($markdown);
}

?>
