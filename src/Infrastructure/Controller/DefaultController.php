<?php

namespace App\Infrastructure\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="id")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function find()
    {
        return $this->json(['item' => 'item']);
    }
}
