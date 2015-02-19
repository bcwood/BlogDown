<?php

if (file_exists("includes/git-config.php"))
{
    header("Location: index.php");
    exit();
}

$local_path = getcwd();

$config = fopen("{$local_path}/includes/git-config.php", "w") 
    or die("Unable to open git-config.php for writing");

fwrite($config, "<?php\n");

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

$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$local_hook_url = substr($current_url, 0, strlen($current_url) - strlen("install.php")) . "git-commit-hook.php";

echo "<b>Use the following settings:</b><br>";
echo "Payload URL: {$local_hook_url}<br>";
echo "Content Type: application/json<br>";
echo "Secret: {$hook_secret}<br>";
echo "Select 'Just the push event'";

?>
