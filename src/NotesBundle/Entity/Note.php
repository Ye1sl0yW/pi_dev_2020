<?php


namespace NotesBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="notes")
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $user_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $type;
    /**
     * @ORM\ManyToOne(targetEntity="ProduitBundle\Entity\Produit")
     * @ORM\JoinColumn(name="produit_id",referencedColumnName="id")
     */
    private $produit_id;
    /**
     * @ORM\ManyToOne(targetEntity="MagasinBundle\Entity\Magasin")
     * @ORM\JoinColumn(name="magasin_id",referencedColumnName="id")
     */
    private $magasin_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $value;

}