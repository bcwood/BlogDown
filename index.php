<?php

if (!file_exists("includes/config.php"))
{
    header("Location: install.php");
    exit();
}

require_once("includes/core.php");

hyde_init();

?>
