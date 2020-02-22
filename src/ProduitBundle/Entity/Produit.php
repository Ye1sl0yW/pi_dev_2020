<?php


namespace ProduitBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Httpfoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Produit
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="la quantité est obligatoire")
     * @Assert\GreaterThan(value=0,
     * message="la quantité doit etre superieur à 0"
     * )
     */
    protected $quantite;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="le nom est obligatoire")
     */
    protected $nom;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\GreaterThan(value=0,
     * message="la prix doit etre superieur à 0"
     * )
     */
    protected $prix;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    protected $marque;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string|null
     */
    private $imageName;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="imageName", mimeType="png")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string|null $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $image
     * @throws \Exception
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


    /**
     * @ORM\ManyToOne(targetEntity="MagasinBundle\Entity\Magasin")
     * @ORM\JoinColumn(name="id_magasin",referencedColumnName="id")
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
     * @return mixed
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param mixed $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
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
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param mixed $marque
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }


    /**
     * @ORM\ManyToMany(targetEntity="Categorie")
     * @ORM\JoinColumn(name="id_categorie",referencedColumnName="id")
     */
    protected $id_categorie;

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
     * Constructor
     */
    public function __construct()
    {
        $this->id_categorie = new \Doctrine\Common\Collections\ArrayCollection();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Add idCategorie
     *
     * @param \ProduitBundle\Entity\Categorie $idCategorie
     *
     * @return Produit
     */
    public function addIdCategorie(\ProduitBundle\Entity\Categorie $idCategorie)
    {
        $this->id_categorie[] = $idCategorie;

        return $this;
    }

    /**
     * Remove idCategorie
     *
     * @param \ProduitBundle\Entity\Categorie $idCategorie
     */
    public function removeIdCategorie(\ProduitBundle\Entity\Categorie $idCategorie)
    {
        $this->id_categorie->removeElement($idCategorie);
    }

    /**
     * Get idCategorie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdCategorie()
    {
        return $this->id_categorie;
    }

}
