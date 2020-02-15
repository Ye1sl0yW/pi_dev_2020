<?php


namespace MagasinBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use MagasinBundle\Entity\Magasin;
use ProduitBundle\Entity\Produit;

class MagasinService
{
    private $em;

    public function __construct( EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function refreshMagasin($id)
    {
        $magasin= $this->em->getRepository(Magasin::class)->find($id);
        $magasin->setTailleStock($this->calculateStock($id));
        $this->em->persist($magasin);
        $this->em->flush();

        return ($magasin);
    }

    public function calculateStock($id)
    {
        $inventaire = $this->em->getRepository(Produit::class)->findBy(array("id_magasin"=>$id));
        return sizeof($inventaire);
    }


}