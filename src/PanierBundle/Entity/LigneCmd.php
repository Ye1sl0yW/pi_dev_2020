<?php

namespace PanierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneCmd
 *
 * @ORM\Table(name="ligne_cmd")
 * @ORM\Entity(repositoryClass="PanierBundle\Repository\LigneCmdRepository")
 */
class LigneCmd
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer")
     */
    private $qte;

    /**
     * @return mixed
     */
    public function getIdCmd()
    {
        return $this->id_cmd;
    }

    /**
     * @param mixed $id_cmd
     */
    public function setIdCmd($id_cmd)
    {
        $this->id_cmd = $id_cmd;
    }

    /**
     * @return mixed
     */
    public function getIdProduit()
    {
        return $this->id_produit;
    }

    /**
     * @param mixed $id_produit
     */
    public function setIdProduit($id_produit)
    {
        $this->id_produit = $id_produit;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="totalLigne", type="decimal", precision=5, scale=2)
     */
    private $totalLigne;


    /**
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumn(name="id_cmd",referencedColumnName="id")
     */
    protected $id_cmd;

    /**
     * @ORM\ManyToOne(targetEntity="ProduitBundle\Entity\Produit")
     * @ORM\JoinColumn(name="id_product",referencedColumnName="id")
     */
    protected $id_produit;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set qte
     *
     * @param integer $qte
     *
     * @return LigneCmd
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return int
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set totalLigne
     *
     * @param float $totalLigne
     *
     * @return LigneCmd
     */
    public function setTotalLigne($totalLigne)
    {
        $this->totalLigne = $totalLigne;

        return $this;
    }

    /**
     * Get totalLigne
     *
     * @return float
     *
     */
    public function getTotalLigne()
    {
        return $this->totalLigne;
    }
}

