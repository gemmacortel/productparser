<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepository
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function saveIfUnique(Product $product): void
    {
        $unique = $this->checkIfProductIsNew($product->getTitle());

        if ($unique) {
            $this->save($product);
        }
    }

    public function save(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function checkIfProductIsNew(string $title)
    {
        return $this->findOneBy(['title' => $title]) === null;
    }

    public function findByTitle(string $title)
    {
        $repository = $this->entityManager->getRepository(Product::class);
        return $repository->findOneBy(['title' => $title]);

    }

}
