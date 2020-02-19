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
        $inventaire = $this->em->getRepository(Produit::class)->findBy(array("id_magasin"=>$id));
        return sizeof($inventaire);
    }

    public function calculateStockByCategory($id, $category)
    {
        //TODO: Implémenter les catégories correctement
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
        //TODO Faire le service value product
        $result = 0;
        $magasin= $this->em->getRepository(Magasin::class)->find($id);
        return $result;
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
        $produits = $this->em->getRepository(Produit::class)->findBy(['id_magasin' => $magasin]);
        $result = array();
        foreach ($produits as $p)
        {
            if($p->getIdCategorie()===$category)
            {
                array_push($result,$p);
            }
        }
        return $result;
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
        $totalProduits = sizeof($this->em->getRepository(Produit::class)->findBy(array('id_magasin',$id)));

        foreach ($categories as $cat )
        {
            $stat = array();
            $nomCat = $cat->getNom();
            $percent = sizeof($this->findAllProductsByShopAndCategory($id,$cat)) *100 /$totalProduits;
            array_push($stat, $nomCat, $percent);
            $stat=[$nomCat,$percent];
            array_push($data, $stat);
        }

        $pieChart->getData()->setArrayToDataTable($data);

        $pieChartOptions = $pieChart->getOptions();
        $pieChartOptions->setTitle('Pourcentage de produits proposés par catégorie');
        $pieChartOptions->setHeight(500);
        $pieChartOptions->setWidth(900);
        $pieChartOptions->getTitleTextStyle()->setBold(true);
        $pieChartOptions->getTitleTextStyle()->setColor('#009900');
        $pieChartOptions->getTitleTextStyle()->setItalic(false);
        $pieChartOptions->getTitleTextStyle()->setFontName('Helvetica');
        $pieChartOptions->getTitleTextStyle()->setFontSize('25');

        return $pieChart;
    }



}