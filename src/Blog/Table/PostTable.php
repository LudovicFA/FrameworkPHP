<?php

namespace App\Blog\Table;

use Framework\Database\PaginatedQuery;
use Pagerfanta\Pagerfanta;
use App\Blog\Entity\Post;

/**
 *
 */
class PostTable
{

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

  //Pagine les articles
    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        $query =  new PaginatedQuery(
            $this->pdo,
            "SELECT * FROM posts ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM posts",
            Post::class
        );
        return (new Pagerfanta($query))
                  ->setMaxPerPage($perPage)
                  ->setCurrentPage($currentPage);
    }

    public function find(int $id): Post
    {
        $query = $this->pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $query->execute([$id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $query->fetch();
    }
}
