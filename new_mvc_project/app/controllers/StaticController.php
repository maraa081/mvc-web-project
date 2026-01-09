<?php

class StaticController
{
    public function blog()
    {
        require __DIR__ . '/../views/static/blog.php';
    }

    public function about()
    {
        require __DIR__ . '/../views/static/about.php';
    }

    public function contact()
    {
        require __DIR__ . '/../views/static/contact.php';
    }
}
