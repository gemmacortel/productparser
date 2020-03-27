<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Product;

interface ProductRepository
{
    public function saveIfUnique(Product $product): void;

}
