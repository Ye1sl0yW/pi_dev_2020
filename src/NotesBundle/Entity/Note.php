<?php


namespace NotesBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="notes")
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    private $user_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $type;
    /**
     * @ORM\ManyToOne(targetEntity="ProduitBundle\Entity\Produit")
     * @ORM\JoinColumn(name="produit_id",referencedColumnName="id")
     */
    private $produit_id;
    /**
     * @ORM\ManyToOne(targetEntity="MagasinBundle\Entity\Magasin")
     * @ORM\JoinColumn(name="magasin_id",referencedColumnName="id")
     */
    private $magasin_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $value;
    /**
     * @ORM\Column(type="text")
     */
    private $text;

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

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getProduitId()
    {
        return $this->produit_id;
    }

    /**
     * @param mixed $produit_id
     */
    public function setProduitId($produit_id)
    {
        $this->produit_id = $produit_id;
    }

    /**
     * @return mixed
     */
    public function getMagasinId()
    {
        return $this->magasin_id;
    }

    /**
     * @param mixed $magasin_id
     */
    public function setMagasinId($magasin_id)
    {
        $this->magasin_id = $magasin_id;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }



}