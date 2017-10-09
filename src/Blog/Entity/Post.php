<?php

namespace App\Blog\Entity;

/**
 *
 */
class Post
{
    public $id;
    public $name;
    public $slug;
    public $content;
    public $created_at;
    public $update_at;

    public function __construct()
    {
        if ($this->created_at) {
            $this->created_at = new \DateTime($this->created_at);
        }
        if ($this->update_at) {
            $this->update_at = new \DateTime($this->update_at);
        }
    }
}
