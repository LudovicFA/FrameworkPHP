<?php

namespace Framework\Database;

use Pagerfanta\Adapter\AdapterInterface;

/**
 *
 */
class PaginatedQuery implements AdapterInterface
{

    private $pdo;
    private $query; // requete pour recupere X result
    private $countQuery; // Requete qui permet de compter le nombre de resultats total
    private $entity;

    public function __construct(\PDO $pdo, string $query, string $countQuery, string $entity)
    {
        $this->pdo = $pdo;
        $this->query = $query;
        $this->countQuery = $countQuery;
        $this->entity = $entity;
    }

    public function getNbResults(): int
    {
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }

    public function getSlice($offset, $length): array
    {
        $statement = $this->pdo->prepare($this->query . ' LIMIT :offset, :length');
        $statement->bindParam('offset', $offset, \PDO::PARAM_INT);
        $statement->bindParam('length', $length, \PDO::PARAM_INT);
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity);

        $statement->execute();
        return $statement->fetchAll();
    }
}
