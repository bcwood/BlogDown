<?php

require_once("config.php");

echo "cd {${LOCAL_PATH}} && git pull {${REMOTE_REPO}} <br>";

exec("cd {${LOCAL_PATH}} && git pull {${REMOTE_REPO}}")
    or die("git pull failed!");

echo "done updating!";

?>