<?php

namespace ProduitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProduitController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Produit/Default/index.html.twig');
    }
}
