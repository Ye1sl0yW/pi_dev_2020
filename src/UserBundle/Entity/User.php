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
     * @OneToOne(targetEntity="MagasinBundle\Entity\Magasin", inversedBy="id_vendeur", cascade={"remove"})
     * @ORM\JoinColumn(name="id_magasin",referencedColumnName="id", nullable=true)
     */
    protected $id_magasin;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @ORM\OneToOne(targetEntity="PointsBundle\Entity\Portfolio",mappedBy="user_id")
     * @ORM\JoinColumn(name="portfolio_id",referencedColumnName="id")
     */
     
     private $portfolio;

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




    public function sendSMS($message){


        $client=new Client(new Client\Credentials\Basic("KEY","KEY"),['base_api_url'=>'https://rest.nexmo.com/sms/json']);
        $client->message()->send([
            'to' => $this->number,
            'from' => 'Shoppy',
            'text' => $message
        ]);

    }




    public function getPoints(){
        $this->portfolio->getTotal();
    }



    }

    public function sms2FA($code){
        $this->sendSMS("Ceci est votre code pour l'authentification double facteur: " . $code);
    }

    public function smsPortfolio(){
        $this->sendSMS("Ceci est le résumé de votre portfolio: " . $this->getPortfolio()->stringify());
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
