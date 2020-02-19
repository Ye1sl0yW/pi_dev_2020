<?php

namespace PanierBundle\Controller;

use PanierBundle\Service\Cart\CartService;
use ProduitBundle\Entity\Produit;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
        return $this->render('@Panier/Panier/cartPage.html.twig',[
            'elms'=>$CartWithData
        ]);
    }









    public function indexAction(SessionInterface  $session)

    {
        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository('ProduitBundle:Produit');

        $panier  = $session->get('panier',[]);

         $CartWithData=[];

         foreach ($panier as $id => $quantite){


             $CartWithData[]=[
                 'produit'=>$productRepository->find($id),
                 'quantite'=> $quantite ,

             ];
         }

         $total=0;
        /* foreach ($CartWithData as $ct)
         {

             $totalct=$ct['produit'] * $ct['quantite'];
             $total+=$totalct;

         }*/
    //  unset( $panier[0]);

   //  exit(VarDumper::dump($CartWithData));
         return $this->render('@Panier/Panier/cartPage.html.twig',[
             'elms'=>$CartWithData,
             'a'=>$total
         ]);

    }






    public function tradeAction()
    { $produit=$this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        return $this->render('@Panier/Panier/trade.html.twig',array('data'=>$produit));

    }







    public  function addAction($id,SessionInterface $session){
//$cartService->add($id);
$panier = $session->get('panier',[]);
if (!empty($panier[$id]))
{
    $panier[$id]++;
}
else
 {     $panier[$id]=1;
    }
////$panier=$this->getDoctrine()->getManager()->getRepository(Panier::class)->find($id);
////$panier[$id]=1;
//
 $session->set('panier',$panier);
////unset($panier[1]);
////exit(VarDumper::dump($session->get('panier')));
        $produit=$this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
      return $this->render('@Panier/Panier/trade.html.twig',array('data'=>$produit));
//        return $this->render('@Panier/Panier/cartPage.html.twig',[
//            'elms'=>$panier,
//            'a'=>$total
//        ]);

    }








    public  function addSupAction($id,SessionInterface $session){
    //    exit(VarDumper::dump($session->get('panier')));
//$cartService->add($id);
        $panier = $session->get('panier',[]);
        if (!empty($panier[$id]))
        {
            $panier[$id]++;}
else
        {
           $panier[$id]=1;
       }
////$panier=$this->getDoctrine()->getManager()->getRepository(Panier::class)->find($id);
////$panier[$id]=1;

      $session->set('panier',$panier);
//unset($panier[1]);

   //   $produit=$this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
      //  return $this->render('@Panier/Panier/trade.html.twig',array('data'=>$produit));
//        return $this->render('@Panier/Panier/cartPage.html.twig',[
//            'elms'=>$panier,
//            'a'=>$total
//        ]);










        $panier  = $session->get('panier',[]);





        /* foreach ($CartWithData as $ct)
         {

             $totalct=$ct['produit'] * $ct['quantite'];
             $total+=$totalct;

         }*/
        //  unset( $panier[0]);


        $CartWithData=[];

        foreach ($panier as $id => $quantite){

            $em = $this->getDoctrine()->getManager();
            $productRepository = $em->getRepository('ProduitBundle:Produit');
            $CartWithData[]=[
                'produit'=>$productRepository->find($id),
                'quantite'=> $quantite ,

            ];
        }
        $total=0;
      //  exit(VarDumper::dump($CartWithData));
        return $this->render('@Panier/Panier/cartPage.html.twig',[
            'elms'=>$CartWithData,
            'a'=>$total
        ]);



    }













    public function RemoveCartAction($id,SessionInterface $session)
    {


        $panier=$session->get('panier',[]);
        if(!empty($panier[$id])){

   unset($panier[$id]);
        }
        $session->set('panier',$panier);
        $this->addFlash('success', 'element removed from the cart.');
        return $this->redirectToRoute('panier_cart');
    }



    public function PDFAction($id,SessionInterface $session){
        $panier  = $session->get('panier',[]);
        $CartWithData=[];

        foreach ($panier as $id => $quantite){

            $em = $this->getDoctrine()->getManager();
            $productRepository = $em->getRepository('ProduitBundle:Produit');
            $CartWithData[]=[
                'produit'=>$productRepository->find($id),
                'quantite'=> $quantite ,

            ];
        }
        $total=0;
        $vars= $this->renderView(
                '@Panier/Panier/pdf.html.twig',
               ['name'=>'omarhachicha' ,
                  'a'=> $CartWithData]
        );


return new Response(
    $this->get('knp_snappy.pdf')->getOutputFromHtml($vars),200,array(
        'Content-type'=>'application/pdf',
        'Content-Disposition'=>'filename="CC.pdf"'
    )

);
    }


}


