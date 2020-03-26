<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Product;

interface ProductRepository
{
    public function save(Product $product): void;

}
