<?php


namespace UserBundle\Entity;

use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Nexmo\Client;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
    implements ParticipantInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string",length=255)
     */

    private $prenom;

    /**
     * @ORM\Column(type="boolean")
     */

    private $sexe;


    /**
     * @ORM\Column(type="string",length=255)
     */

    private $tel;

    /**
     * @ORM\OneToOne(targetEntity="PointsBundle\Entity\Portfolio",mappedBy="user_id",cascade={"persist"})
     * @ORM\JoinColumn(name="portfolio_id",referencedColumnName="id")
     *
     */

    private $portfolio;

    /**
     * @return mixed
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * @param mixed $portfolio
     */
    public function setPortfolio($portfolio)
    {
        $this->portfolio = $portfolio;
    }

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

        $client=new Client(new Client\Credentials\Basic("AAAA","AAAAA"),['base_api_url'=>'https://rest.nexmo.com/sms/json']);
        $client->message()->send([
            'to' => $this->tel,
            'from' => 'Shoppy',
            'text' => $message
        ]);

    }

    public function sms2FA($code){
        $this->sendSMS("Ceci est votre code pour l'authentification double facteur: " . $code);
    }

    public function smsPortfolio(){
        $this->sendSMS("Ceci est le résumé de votre portfolio: " . $this->getPortfolio()->stringify());
    }

    public function getPoints(){
        $this->portfolio->getTotal();
    }
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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



}