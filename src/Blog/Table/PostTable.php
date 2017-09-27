<?php

namespace App\Blog\Table;

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
    public function findPaginated(): array
    {
        return $this->pdo
        ->query('SELECT * FROM posts ORDER BY created_at LIMIT 10')
        ->fetchAll();
    }

    public function find(int $id): \stdClass
    {
        $query = $this->pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
    }
}
