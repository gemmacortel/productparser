<?php

namespace App\Application;

use App\Application\DTO\ProductData;
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

    public function execute(string $title, string $link, \DateTime $pubDate)
    {
        $product = new Product($title, $link, $pubDate);
        $this->productRepository->save($product);

        return new ProductData(
            $product->getId(),
            $product->getTitle(),
            $product->getLink(),
            $product->getPubDate()
            );

    }
}
