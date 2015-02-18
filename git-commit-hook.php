<?php

require_once("config.php");

echo "cd {${LOCAL_PATH}} && git pull <br>";

exec("cd {${LOCAL_PATH}} && git pull")
    or die("git pull failed!");

echo "done updating!";

?>