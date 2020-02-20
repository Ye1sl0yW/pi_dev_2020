<?php


namespace PointsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
/**
 * @ORM\Entity
 * @ORM\Table(name="portfolios")
 */

class Portfolio
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User",inversedBy="portfolio")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */

    private $user_id;

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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }





    public function getTotal(){

    }

    public function stringify(){
        return "ID: ".$this->getId()."Total points: ".$this->getTotal();
    }
}