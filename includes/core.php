<?php

function the_title()
{
    $title = BLOG_TITLE;
    
    global $post;
    
    if (isset($post))
    {
        $title = "$post->title - $title";
    }
    
    return $title;
}

?>