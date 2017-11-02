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

    public function find(int $id): ?Post
    {
        $query = $this->pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $query->execute([$id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, Post::class);
        return $query->fetch() ?: null;
    }

    public function update(int $id, array $params): bool
    {
        $fieldQuery = $this->buildFieldQuery($params);
        $params["id"] = $id;
        $statement = $this->pdo->prepare("UPDATE posts SET $fieldQuery WHERE id = :id");
        return $statement->execute($params);
    }

    public function insert(array $params): bool
    {
        $fields = array_keys($params);
        $values = array_map(function ($field) {
            return ':' . $field;
        }, $fields);
        $statement = $this->pdo->prepare(
            "INSERT INTO posts (" . join(',', $fields) . ") VALUES (" . join(',', $values) . ") "
        );
        return $statement->execute($params);
    }

    public function delete(int $id): bool
    {
        $query = $this->pdo->prepare("DELETE FROM posts WHERE id = ?");
        return $query->execute([$id]);
    }

    private function buildFieldQuery($params)
    {
        return join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
    }
}
