<?php

namespace App\Application;

use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepository;

class ProductCreator
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(string $title, string $link): void
    {
        $product = new Product($title, $link);
        $this->productRepository->saveIfUnique($product);
    }
}
