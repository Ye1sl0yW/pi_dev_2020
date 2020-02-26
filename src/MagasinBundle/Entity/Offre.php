<?php


namespace MagasinBundle\Entity;

use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Le taux est obligatoire !")
     * @Assert\GreaterThanOrEqual(value=0 , message="Le taux doit être positif! ")
     * @Assert\LessThanOrEqual(value=1, message="Le taux doit être inférieur à 100%")
     */
    private $taux;

    /**
     * @ORM\Column(type="string", options={"default": "AJOUTER NOM"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", nullable = true, options={"default": "AJOUTER DESCRIPTION"})
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual("today")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual(propertyPath="dateDebut")
     */
    private $dateFin;

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param mixed $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }



}
