<?php


namespace MagasinBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToOne;
use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class Magasin
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(type="string")
     */
    private $nom;



    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tailleStock;



    /**
     * @ORM\Column(type="integer")
     */
    private $matriculeFiscal;

    /**
     * @OneToOne(targetEntity="UserBundle\Entity\User", mappedBy="id_magasin", cascade={"remove","persist"})
     * @ORM\JoinColumn(name="id_vendeur",referencedColumnName="id", nullable=true)
     */
    private $id_vendeur;

    /**
     * @return mixed
     */
    public function getIdVendeur()
    {
        return $this->id_vendeur;
    }

    /**
     * @param mixed $id_vendeur
     */
    public function setIdVendeur($id_vendeur)
    {
        $this->id_vendeur = $id_vendeur;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getTailleStock()
    {
        return $this->tailleStock;
    }

    /**
     * @param mixed $tailleStock
     */
    public function setTailleStock($tailleStock)
    {
        $this->tailleStock = $tailleStock;
    }

    /**
     * @return mixed
     */
    public function getMatriculeFiscal()
    {
        return $this->matriculeFiscal;
    }

    /**
     * @param mixed $matriculeFiscal
     */
    public function setMatriculeFiscal($matriculeFiscal)
    {
        $this->matriculeFiscal = $matriculeFiscal;
    }





}
