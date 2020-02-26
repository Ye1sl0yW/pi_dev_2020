<?php

namespace SAVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * rep
 *
 * @ORM\Table(name="rep")
 * @ORM\Entity(repositoryClass="SAVBundle\Repository\repRepository")
 */
class rep
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
     * @ORM\Column(name="nomResponsable", type="string", length=255)
     * @Assert\NotBlank
     */
    private $nomResponsable;

    /**
     * @var string
     *
     * @ORM\Column(name="repo", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=5)
     */
    private $repo;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRep", type="date")
     */
    private $dateRep;

    /**
     * @return \DateTime
     * @Assert\GreaterThanOrEqual("today")
     */
    public function getDateRep()
    {
        return $this->dateRep;
    }

    /**
     * @param \DateTime $dateRep
     */
    public function setDateRep($dateRep)
    {
        $this->dateRep = $dateRep;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomResponsable
     *
     * @param string $nomResponsable
     *
     * @return rep
     */
    public function setNomResponsable($nomResponsable)
    {
        $this->nomResponsable = $nomResponsable;

        return $this;
    }

    /**
     * Get nomResponsable
     *
     * @return string
     */
    public function getNomResponsable()
    {
        return $this->nomResponsable;
    }

    /**
     * Set repo
     *
     * @param string $repo
     *
     * @return rep
     */
    public function setRepo($repo)
    {
        $this->repo = $repo;

        return $this;
    }

    /**
     * Get repo
     *
     * @return string
     */
    public function getRepo()
    {
        return $this->repo;
    }

    /**
     * @return mixed
     */
    public function getRec()
    {
        return $this->rec;
    }

    /**
     * @param mixed $rec
     */
    public function setRec($rec): void
    {
        $this->rec = $rec;
    }

    /**
     *@ORM\ManyToOne(targetEntity="SAVBundle\Entity\rec")
     *
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="rec",referencedColumnName="id",onDelete="CASCADE")
     * })
     */

    private $rec;
}

