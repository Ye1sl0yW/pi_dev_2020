<?php


namespace MagasinBundle\Service;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\ORM\EntityManagerInterface;
use MagasinBundle\Entity\Magasin;
use ProduitBundle\Entity\Categorie;
use ProduitBundle\Entity\Produit;
use UserBundle\Entity\User;

class MagasinService
{
    private $em;

    public function __construct( EntityManagerInterface $em)
    {
        $this->em = $em;
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
        $mg->setTailleStock(0);
        $mg->setMatriculeFiscal(0);
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
            //if($p->getIdCategorie() ===$category)
            if (in_array($category,$categoriesList))
            {
                array_push($result,$p);
            }
        }
        return $result;
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

    public function findAllProductsByShop($id)
    {
        $magasin= $this->em->getRepository(Magasin::class)->find($id);
        return ($this->em->getRepository(Produit::class)->findBy(array('id_magasin' => $id)));
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
        $totalProduits = sizeof($this->em->getRepository(Produit::class)->findBy(array('id_magasin' => $id)));

        foreach ($categories as $cat )
        {
            $stat = array();
            $nomCat = $cat->getNom();
            //$er = $this->em->getRepository(Produit::class);
            //$percent = ($er->findAllProductsByShopAndCategory($magasin,$cat)) *100 /$totalProduits;
            $percent = ( sizeof($this->findAllProductsByShopAndCategory($magasin,$cat)) *100 /$totalProduits );
            array_push($stat, $nomCat, $percent);
            $stat=[$nomCat,$percent];
            array_push($data, $stat);
        }

        $pieChart->getData()->setArrayToDataTable($data);

        $pieChartOptions = $pieChart->getOptions();
        $pieChartOptions->setTitle('Pourcentages de produits proposés par catégorie');
        $pieChartOptions->setHeight(400);
        $pieChartOptions->setWidth(700);
        $pieChartOptions->setPieResidueSliceColor('black');
        $pieChartOptions->setPieResidueSliceLabel('Add more data');
        $pieChartOptions->setBackgroundColor('#151933');
        $pieChartOptions->getTitleTextStyle()->setBold(true);
        $pieChartOptions->getTitleTextStyle()->setColor('#009900');
        $pieChartOptions->getTitleTextStyle()->setItalic(false);
        $pieChartOptions->getTitleTextStyle()->setFontName('Poppins');
        $pieChartOptions->getTitleTextStyle()->setFontSize('25');

        return $pieChart;
    }



}