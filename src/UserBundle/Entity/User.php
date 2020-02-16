<?php


namespace UserBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToOne;
use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nom;

    /**
     * @ORM\Column(type="string")
     */
    protected $prenom;


    /**
     * @ORM\Column(type="boolean")
     */
    protected $sexe;

    /**
     * @ORM\Column(type="bigint")
     */
    protected $tel;

    /**
     * @OneToOne(targetEntity="MagasinBundle\Entity\Magasin", inversedBy="id_vendeur", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id_magasin",referencedColumnName="id", nullable=true)
     */
    protected $id_magasin;


    public function __construct()
    {
        parent::__construct();
        //TODO finir le user
    }


    /*
    * Getters and setters
    */

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
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param mixed $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
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
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }





}
