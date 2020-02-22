<?php


namespace UserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function addMagasin($id_vendeur, $magasin)
    {
        $qb = $this->getEntityManager()->createQuery(
            "UPDATE UserBundle:User vd set vd.id_magasin = :magasin WHERE  id= :id_vendeur"
        )->setParameter('id_vendeur',$id_vendeur)
         ->setParameter('magasin',$magasin);
    }
}