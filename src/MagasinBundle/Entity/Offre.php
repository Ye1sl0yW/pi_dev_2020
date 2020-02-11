<?php


namespace MagasinBundle\Entity;

use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class Offre
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $taux;



    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity="Magasin")
     * @ORM\JoinColumn(name="id_magasin",referencedColumnName="id")
     */
    private $id_magasin;

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
    public function getTaux()
    {
        return $this->taux;
    }

    /**
     * @param mixed $taux
     */
    public function setTaux($taux)
    {
        $this->taux = $taux;
    }

    /**
     * @return mixed
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param mixed $duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    }

    /**
     * @return mixed
     */
    public function getIdMagasin()
    {
        return $this->id_magasin;
    }

    /**
     * @param mixed $id_magasin
     */
    public function setIdMagasin($id_magasin)
    {
        $this->id_magasin = $id_magasin;
    }

}
