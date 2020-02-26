<?php

namespace PanierBundle\Entity;
use UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="PanierBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=10, scale=2)
     */
    private $total;

    /**
     * @var int
     *
     * @ORM\Column(name="QteTot", type="integer")
     */
    private $qteTot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @return mixed
     */
    public function getAdresseLiv()
    {
        return $this->adresseLiv;
    }

    /**
     * @param mixed $adresseLiv
     */
    public function setAdresseLiv($adresseLiv)
    {
        $this->adresseLiv = $adresseLiv;
    }

    /**
     * @ORM\Column(type="string")
     */
    protected $adresseLiv;

    /**
     * @return mixed
     */
    public function getIdAcheteur()
    {
        return $this->id_Acheteur;
    }

    /**
     * @param mixed $id_Acheteur
     */
    public function setIdAcheteur($id_Acheteur)
    {
        $this->id_Acheteur = $id_Acheteur;
    }

    /**
     * Get id
     *
     * @return int
     */

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_Acheteur",referencedColumnName="id")
     */
private $id_Acheteur ;
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return Commande
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set qteTot
     *
     * @param integer $qteTot
     *
     * @return Commande
     */
    public function setQteTot($qteTot)
    {
        $this->qteTot = $qteTot;

        return $this;
    }

    /**
     * Get qteTot
     *
     * @return int
     */
    public function getQteTot()
    {
        return $this->qteTot;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Commande
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation =$dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }


}

