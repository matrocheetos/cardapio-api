<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\DatabaseService;
use SQLite3;

abstract class BaseRepository extends ServiceEntityRepository
{
    protected $entityManager;
    protected DatabaseService $db;

    public function __construct(ManagerRegistry $registry, string $entityClass, DatabaseService $databaseService)
    {
        parent::__construct($registry, $entityClass);
        $this->entityManager = $this->getEntityManager();
        $this->db = $databaseService;
    }

    // public function lista($entity)
    // {
    //     $this->entityManager->find($entity, null);
    //     $this->entityManager->flush();
    // }

    // public function listaId($entity, $id)
    // {
    //     $this->entityManager->find($entity, $id);
    //     $this->entityManager->flush();
    // }
}