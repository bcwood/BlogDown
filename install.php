<?php

$local_path = getcwd();

$config = fopen("{$local_path}/config.php", "w") or die("Unable to open config.php for writing");
fwrite($config, "<?php\n");

fwrite($config, "define('LOCAL_PATH', '{$local_path}');\n");

$remote_repo = passthru("git config --get remote.origin.url");
fwrite($config, "define('REMOTE_REPO', '{$remote_repo}');\n");

$hook_secret = substr(sha1(rand()), 0, 20);
fwrite($config, "define('COMMIT_HOOK_SECRET', '{$hook_secret}');\n");

fwrite($config, "?>");
fclose($config);

echo "Setup is almost done!<br><br>";

$create_hook_url = substr($remote_repo, 0, strlen($remote_repo) - 4);
$create_hook_url .+ "/settings/hooks/new";
echo "The only thing left to do is <a href='{$create_hook_url}' target='blank'>create a commit hook at GitHub</a>, 
      so that any time you commit changes, they will automatically be deployed:<br><br>";

$local_hook_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$local_hook_url = substr($local_hook_url, 0, len("install.php"));
$local_hook_url .= "git-commit-hook.php";

echo "Payload URL: {$local_hook_url}<br>";
echo "Payload Type: form/post<br>";
echo "Payload secret: {$hook_secret}";

?>