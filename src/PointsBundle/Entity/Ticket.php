<?php


namespace PointsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tickets")
 */

class Ticket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $montant;
    /**
     * @ORM\Column(type="date")
     */
    private $date_exp;

    /**
     * @ORM\ManyToOne(targetEntity="Portfolio")
     * @ORM\JoinColumn(name="portfolio_id",referencedColumnName="id")
     */

    private $portfolio;

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
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param mixed $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * @return mixed
     */
    public function getDateExp()
    {
        return $this->date_exp;
    }

    /**
     * @param mixed $date_exp
     */
    public function setDateExp($date_exp)
    {
        $this->date_exp = $date_exp;
    }

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


}