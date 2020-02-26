<?php


namespace MagasinBundle\Service;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\ORM\EntityManagerInterface;
use MagasinBundle\Entity\Magasin;
use MagasinBundle\Entity\Offre;
use MagasinBundle\Form\MagasinType;
use ProduitBundle\Entity\Categorie;
use ProduitBundle\Entity\Produit;
use UserBundle\Entity\User;

use Symfony\Component\HttpFoundation\Request;


class MagasinService
{
    private $em;

    public function __construct( EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAllShops()
    {
        return ($this->em->getRepository(Magasin::class)->findAll());
    }

    public function deleteShop($id)
    {
        $magasin=$this->em->getRepository(Magasin::class)->find($id);

        $products=$this->findAllProductsByShop($id);
        foreach($products as $p)
        {
            $this->em->remove($p);
        }

        $offres=$this->findAllOffersByShop($id);
        foreach($offres as $o)
        {
            $this->em->remove($o);
        }

        $vendeur=$this->em->getRepository(User::class)->find($magasin);
        if($vendeur !== null )
        {
            $this->em->remove($vendeur);
        }

        $this->em->remove($magasin);
        $this->em->flush();
    }

    public function refreshMagasin($id)
    {
        $magasin= $this->em->getRepository(Magasin::class)->find($id);
        $magasin->setTailleStock($this->calculateStock($id));
        $this->em->persist($magasin);
        $this->em->flush();

        return ($magasin);
    }

    public function calculateStock($id)
    {
        $stock = 0;
        $products = $this->em->getRepository(Produit::class)->findBy(array("id_magasin"=>$id));

        foreach($products as $p )
        {
            $stock += $p->getQuantite();
        }
        return $stock;
    }

    public function calculateStockByCategory($id, $category)
    {
        $inventaire = $this->em->getRepository(Produit::class)->findBy(array("id_magasin"=>$id));
        return sizeof($inventaire);
    }

    public function addManager($id_maggasin, $id_vendeur)
    {
        $magasin= $this->em->getRepository(Magasin::class)->find($id_maggasin);
        if($id_vendeur != null)
        {
            $vendeur =  $this->em->getRepository(User::class)->find($id_vendeur);
            $vendeur->setIdMagasin($magasin);
            $this->em->persist($vendeur);
            $this->em->flush();
        }
    }

    public function value($id)
    {
        $value = 0;
        $magasin= $this->em->getRepository(Magasin::class)->find($id);
        $products = $this->em->getRepository(Produit::class)->findBy(array("id_magasin"=>$id));

        foreach($products as $p )
        {
            $value += $p->getQuantite()*$p->getPrix();
        }
        return $value;
    }

    public function createDefaultMagasin($id_user)
    {
        $mg = new Magasin();
        $mg->setIdVendeur($id_user);
        $mg->setNom("Magasin");
        $mg->setTailleStock(0);
        $mg->setMatriculeFiscal(0);

        $this->em->persist($mg);
        $this->em->flush();

        return $mg;
    }

    public function findAllProductsByShopAndCategory($id_magasin,$category)
{
    $magasin= $this->em->getRepository(Magasin::class)->find($id_magasin);
    $produits = $this->em->getRepository(Produit::class)->findBy(array('id_magasin' => $id_magasin));
    $result = array();
    foreach ($produits as $p)
    {
        $categoriesList = $p->getIdCategorie()->getValues();
        if (in_array($category,$categoriesList))
        {
            array_push($result,$p);
        }
    }
    return $result;
}

    public function calculateArticlesByShopAndCategory($id_magasin,$category)
    {
        $magasin= $this->em->getRepository(Magasin::class)->find($id_magasin);
        $produits = $this->em->getRepository(Produit::class)->findBy(array('id_magasin' => $id_magasin));
        $result = 0;
        foreach ($produits as $p)
        {
            $categoriesList = $p->getIdCategorie()->getValues();
            if (in_array($category,$categoriesList))
            {
                $result+=(int)$p->getQuantite();
            }
        }
        return $result;
    }

    public function findAllProductsByShop($id)
    {
       // $magasin= $this->em->getRepository(Magasin::class)->find($id);
        return ($this->em->getRepository(Produit::class)->findBy(array('id_magasin' => $id)));
    }

    public function findAllOffersByShop($id)
    {
        $magasin= $this->em->getRepository(Magasin::class)->find($id);
        return ($this->em->getRepository(Offre::class)->findBy(array('id_magasin' => $id)));
    }


    public function bestSellers($magasin)
    {
        //TODO implémenter la classe vente
        return 0;
    }

    public function calculateTurnOverByMonth($magasin)
    {
        //TODO implémenter la fonction de calcul du chiffre d'affaire par mois
        return 0;
    }

    public function calculateTurnOverByYear($magasin)
    {
        //TODO implémenter la fonction de calcul du chiffre d'affaire par année
        return 0;
    }

    public function calculateTurnOverForCurrentYear($magasin)
    {
        //TODO implémenter la fonction de calcul du chiffre d'affaire pour l'année en cours
        return 0;
    }


    /*
     * Statistics Methods
     */



    public function pieChartOfNumberOfProductsByCategory($id)
    {
        $pieChart = new PieChart();
        $data = array();
        $stat = ['Catégorie','Nombre de produits'];
        $percent = 0;
        array_push($data,$stat);

        $magasin= $this->em->getRepository(Magasin::class)->find($id);
        $categories = $this->em->getRepository(Categorie::class)->findAll();

        foreach ($categories as $cat )
        {
            $stat = array();
            $nomCat = $cat->getNom();
            $percent = ( sizeof($this->findAllProductsByShopAndCategory($magasin,$cat)) );
            array_push($stat, $nomCat, $percent);
            $stat=[$nomCat,$percent];
            array_push($data, $stat);
        }

        $pieChart->getData()->setArrayToDataTable($data);

        $pieChartOptions = $pieChart->getOptions();
        $pieChartOptions->setTitle('Représentation des catégories par nombre de produits');
        $pieChartOptions->setHeight(400);
        $pieChartOptions->setWidth(700);
        $pieChartOptions->setPieResidueSliceColor('black');
        $pieChartOptions->setPieResidueSliceLabel('Add more data');
        $pieChartOptions->setBackgroundColor('#151933');
        $pieChartOptions->getTitleTextStyle()->setBold(true);
        $pieChartOptions->getTitleTextStyle()->setColor('#009900');
        $pieChartOptions->getTitleTextStyle()->setItalic(false);
        $pieChartOptions->getTitleTextStyle()->setFontName('Poppins');
        $pieChartOptions->getTitleTextStyle()->setFontSize('20');

        return $pieChart;
    }


    public function pieChartOfNumberOfArticlesByCategory($id)
    {
        $pieChart = new PieChart();
        $data = array();
        $stat = ['Catégorie','Nombre d\' articles'];
        $percent = 0;
        array_push($data,$stat);

        $magasin= $this->em->getRepository(Magasin::class)->find($id);
        $categories = $this->em->getRepository(Categorie::class)->findAll();

        foreach ($categories as $cat )
        {
            $stat = array();
            $nomCat = $cat->getNom();
            $percent = ( $this->calculateArticlesByShopAndCategory($magasin,$cat)) ;
            array_push($stat, $nomCat, $percent);
            $stat=[$nomCat,$percent];
            array_push($data, $stat);
        }

        $pieChart->getData()->setArrayToDataTable($data);

        $pieChartOptions = $pieChart->getOptions();
        $pieChartOptions->setTitle('Représentation des catégories par nombre de produits');
        $pieChartOptions->setHeight(400);
        $pieChartOptions->setWidth(700);
        $pieChartOptions->setPieResidueSliceColor('black');
        $pieChartOptions->setPieResidueSliceLabel('Add more data');
        $pieChartOptions->setBackgroundColor('#151933');
        $pieChartOptions->getTitleTextStyle()->setBold(true);
        $pieChartOptions->getTitleTextStyle()->setColor('#009900');
        $pieChartOptions->getTitleTextStyle()->setItalic(false);
        $pieChartOptions->getTitleTextStyle()->setFontName('Poppins');
        $pieChartOptions->getTitleTextStyle()->setFontSize('20');

        return $pieChart;
    }



}