<?php

namespace PanierBundle\Controller;

use PanierBundle\Entity\Panier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use ProduitBundle\Entity\Produit;
use ProduitBundle\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProduitBundle\Repos;
use Symfony\Component\VarDumper\VarDumper;

class PanierController extends Controller
{
    public function showCartAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository('ProduitBundle:Produit');
        $productsArray = [];
        $cart = [];
        $totalSum = 0;

        $cookies = $request->cookies->all();

        if (isset($cookies['cart'])) {
            $cart = json_decode($cookies['cart']);
        }

        foreach ($cart as $id => $quantite) {
            /**
             * @var Produuit $product
             */
            $product = $productRepository->find((int)$id);
            if (is_object($product)) {
                $productPosition = [];

                $quantity = abs((int)$quantite);
                $prix = $product->getPrix();
                $sum = $prix * $quantite;

                $productPosition['product'] = $product;
                $productPosition['quantite'] = $quantite;
                $productPosition['prix'] = $prix;
                $productPosition['sum'] = $sum;
                $totalSum += $sum;

                $productsArray[] = $productPosition;
            }
        }

        $CartWithData[]=  ['products' => $productsArray,
            'totalsum' => $totalSum
        ];
      //exit(VarDumper::dump($cart));
        return $this->render('@Panier/Panier/cart.html.twig',$CartWithData);
    }
    public function indexAction(SessionInterface  $session)

    {
        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository('ProduitBundle:Produit');

        $panier  = $session->get('panier',[]);


         $CartWithData=[];
         foreach ($panier as $id =>$quantite){
             $CartWithData[]=[
                 'produit'=>$productRepository->find($id),
                 'quantite'=> $quantite
             ];
         }
       unset( $CartWithData[3]);
        // exit(VarDumper::dump($CartWithData));
         return $this->render('@Panier/Panier/cart.html.twig',[
             'elms'=>$CartWithData
         ]);

    }
    public function tradeAction()
    { $produit=$this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        return $this->render('@Panier/Panier/trade.html.twig',array('data'=>$produit));

    }

    public  function addAction($id,SessionInterface $session){

$panier = $session->get('panier',[]);
if (!empty($panier[$id]))
{
    $panier[$id]++;
}
else
    {
        $panier[$id]=1;
    }
//$panier=$this->getDoctrine()->getManager()->getRepository(Panier::class)->find($id);
//$panier[$id]=1;

  $session->set('panier',$panier);

//exit(VarDumper::dump($session->get('panier')));
        $produit=$this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
       return $this->render('@Panier/Panier/trade.html.twig',array('data'=>$produit));

    }
}
