<?php

if (file_exists("includes/config.php"))
{
    header("Location: index.php");
    exit();
}

$local_path = getcwd();

$config = fopen("{$local_path}/includes/config.php", "w") 
    or die("Unable to open config.php for writing");

fwrite($config, "<?php\n");

fwrite($config, "// CUSTOMIZE THESE\n");

fwrite($config, "define('BLOG_TITLE', 'Hyde Sample Site');\n");
fwrite($config, "define('THEME', 'default');\n");

fwrite($config, "\n// DON'T TOUCH THESE\n");
fwrite($config, "define('VERSION', '0.1');\n");

$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$root_url = substr($current_url, 0, strlen($current_url) - strlen("install.php") - 1);
fwrite($config, "define('BLOG_URL', '$root_url');\n");

$hook_secret = substr(sha1(rand()), 0, 20);
fwrite($config, "define('COMMIT_HOOK_SECRET', '{$hook_secret}');\n");

fwrite($config, "?>");
fclose($config);

echo "Setup is almost done!<br><br>";

$remote_repo = exec("git config --get remote.origin.url");
$create_hook_url = substr($remote_repo, 0, strlen($remote_repo) - 4);
$create_hook_url .= "/settings/hooks/new";

echo "The only thing left to do is <a href='{$create_hook_url}' target='blank'>create a commit hook at GitHub</a>,
      so that any time you commit changes, they will automatically be deployed:<br><br>";

$local_hook_url = "$root_url/git-commit-hook.php";

echo "<b>Use the following settings:</b><br>";
echo "Payload URL: {$local_hook_url}<br>";
echo "Content Type: application/json<br>";
echo "Secret: {$hook_secret}<br>";
echo "Select 'Just the push event'";

?>
