<?php

class PageController
{
    public function blog()
    {
        require __DIR__ . '/../views/blog.php';
    }

    public function about()
    {
        require __DIR__ . '/../views/about.php';
    }

    public function contact()
    {
        require __DIR__ . '/../views/contact.php';
    }
}
