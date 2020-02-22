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
class User extends BaseUser implements ParticipantInterface
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
     * @ORM\Column(type="string",length=255)
     */

    private $number;

    /**
     * @ORM\OneToOne(targetEntity="PointsBundle\Entity\Portfolio",mappedBy="user_id")
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

    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
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

        $client=new Client(new Client\Credentials\Basic("f481785d","pIO6oRfhxut8UBG0"),['base_api_url'=>'https://rest.nexmo.com/sms/json']);
        $client->message()->send([
            'to' => $this->number,
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
}