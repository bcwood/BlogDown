<?php

require_once("Parsedown.php");

class Post
{
    function __construct($path)
    {
        if (!file_exists($path))
        {
            http_response_code(404);
            $path = "content/pages/404.md";
        }
        
        // parse yaml header
        $file = file_get_contents($path);
        $lines = explode("\r\n", $file);    
        for ($i = 1; $i < count($lines); $i++)
        {
            $line = $lines[$i];

            if (strpos($line, '---') !== FALSE)
                break;

            $parts = explode(': ', $line, 2);

            $varName = trim($parts[0]);
            $this->$varName = trim($parts[1]);
        }
        
        if (property_exists($this, "published") && strtolower($this->published == "false"))
            $this->published = false;
        else
            $this->published = true;

        // extract the remainder of the markdown document (with yaml header removed)
        $markdown = implode("\r\n", array_splice($lines, $i + 1));

        // parse markdown
        $parsedown = new Parsedown();
        $this->body = $parsedown->text($markdown);

        // parse date & permalink from filename
        $filename = basename($path);
        if (preg_match("/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $filename, $matches) === 1)
        {
            $this->type = "post";
            $this->date = new DateTime($matches[0]);
            $slug = substr($filename, strlen($matches[0]) + 1, -3);
            $this->permalink = BLOG_URL . "/" . $this->date->format("Y/m/d") . "/$slug";
        }
        else
        {
            $this->type = "page";
            $slug = substr($filename, 0, -3);
            $this->permalink = BLOG_URL . "/$slug";
        }

        return $this;
    }
}

?>