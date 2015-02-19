<?php

function the_title()
{
    $title = BLOG_TITLE;
    
    if (isset($post))
    {
        $title = "$post->title - $title";
    }
    
    return $title;
}

?>