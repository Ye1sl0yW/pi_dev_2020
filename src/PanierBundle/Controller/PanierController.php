<?php

namespace PanierBundle\Controller;
use UserBundle\Entity\User;
use Knp\Component\Pager\Paginator;
use MagasinBundle\Form\MagasinType;
use MagasinBundle\Service\MagasinService;
use PanierBundle\Entity\Commande;
use PanierBundle\Entity\LigneCmd;
use PanierBundle\Form\CommandeType;
use PanierBundle\PanierBundle;
use PanierBundle\Service\Cart\CartService;
use ProduitBundle\Entity\Produit;
use ProduitBundle\ProduitBundle;
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









    public function indexAction(SessionInterface  $session ,Request $request)

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

        $paginator=$this->get('knp_paginator');
       // dump(get_class($paginator));
       $result= $paginator->paginate(
            $CartWithData,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5)

        );
         return $this->render('@Panier/Panier/cartPage.html.twig',[
             'elms'=>$CartWithData,
             'a'=>$total,
             'pagination'=>$result
         ]);

    }






    public function tradeAction(Request $request,SessionInterface $session)
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository( 'ProduitBundle:Produit')->findAll();
        /**
         * @var $paginator Paginator
         */
        $paginator=$this->get('knp_paginator');

        $result= $paginator->paginate(
            $produit,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5)

        );
        return $this->render('@Panier/Panier/trade.html.twig',array('data'=>$produit, 'pagination'=>$result));

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


    public  function addMAction($id,SessionInterface $session){
        $panier = $session->get('panier',[]);
        if (!empty($panier[$id]))
        {
            $panier[$id]--;}
        else
        {
            $panier[$id]=1;
        }
        $session->set('panier',$panier);
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
        //  exit(VarDumper::dump($CartWithData));
        return $this->render('@Panier/Panier/cartPage.html.twig',[
            'elms'=>$CartWithData,
            'a'=>$total
        ]);

    }














    public function RemoveCartAction($id,SessionInterface $session)
    {
        $panier=$session->get('panier',[]);
        unset($panier[$id]);


        if(!empty($panier[$id])){
            unset($panier[$id]);
            exit(VarDumper::dump($panier));
          //  $this->get('session')->remove('panier');

        }
        $session->set('panier',$panier);


        $this->addFlash('success', 'element removed from the cart.');
        return $this->redirectToRoute('cart_show');
    }


    public function OrderAction(SessionInterface $session,Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository( 'ProduitBundle:Produit')->findAll();
        /*$order = new Commande();
        $form = $this->createForm(CommandeType::class, $order);
        $form->handleRequest($request);*/
        $panier=$session->get('panier',[]);
        /*if ($form->isValid()) {
            $em->persist($form);
            $em->flush();

            if ($order->getId() !== null)
            {
                $id_vendeur = $magasin->getIdVendeur()->getId();
                $this->get(MagasinService::class)->addManager($magasin->getId(),$id_vendeur);
            }

            return $this->redirectToRoute('magasin_homepage');
        }*/
        $CartWithData=[];
        $test=null;
        foreach ($panier as $id => $quantite){
            $em = $this->getDoctrine()->getManager();
            $productRepository = $em->getRepository('ProduitBundle:Produit');

            $magasinRepository = $em->getRepository('MagasinBundle:Magasin');
            $CartWithData[]=[
                'produit'=>$productRepository->find($id),
                'magasin'=>$productRepository->find($id)->getIdMagasin(),
                'quantite'=> $quantite ,
                'magasinn'=>$magasinRepository->findAll()
            ];
        }
       // exit(VarDumper::dump($CartWithData));
        if ( empty($CartWithData ))

{
    $this->addFlash('alert', "votre panier vide  veuillez le remplir ");
          return   $this->redirectToRoute('panier_trade');}
        $total=0;

       //exit(VarDumper::dump($CartWithData));
        return $this->render('@Panier/Panier/order.html.twig',array('data'=>$produit,'panier'=>$CartWithData,'a'=>$total));

    }
    public function CreateOrderAction(SessionInterface $session,Request $request)
    {


        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository( 'ProduitBundle:Produit')->findAll();
        $panier=$session->get('panier',[]);
        $CartWithData=[];
        $test=null;


        $order=new Commande();

        $order->setAdresseLiv($request->get('adr'));
        $date = new \DateTime();
        //  $date = date('Y-m-d h:m:s');
        $order->setDateCreation($date);
        $order->setQteTot($request->get('qte'));
        $order->setTotal($request->get('total'));

        $em = $this->getDoctrine()->getManager();
        $user= $em->getRepository('UserBundle:User')->find($this->get('security.token_storage')->getToken()->getUser());
        $order->setIdAcheteur($user);
        $em->persist($order);
        $em->flush();

       //exit(VarDumper::dump($user));

        foreach ($panier as $id => $quantite){
            $em = $this->getDoctrine()->getManager();
            $productRepository = $em->getRepository('ProduitBundle:Produit');

            $magasinRepository = $em->getRepository('MagasinBundle:Magasin');
            $CartWithData[]=[
                'produit'=>$productRepository->find($id),
                'magasin'=>$productRepository->find($id)->getIdMagasin(),
                'quantite'=> $quantite ,
                'magasinn'=>$magasinRepository->findAll()
            ];
            $CartWithData['produit']=$productRepository->find($id);
            $CartWithData['quantite']=$quantite;
            $p = $em->getRepository(Produit::class)->find($CartWithData['produit']->getId());


            $lc= new LigneCmd();
            $lc->setQte($CartWithData['quantite']);
            $lc->setIdProduit($p);
            $lc->setIdCmd($order);
            $lc->setTotalLigne($CartWithData['quantite']* $p->getPrix());

//exit(VarDumper::dump($lc));
            $em->persist($lc);
            $em->flush();




        }

/*
        foreach ($CartWithData as $id => $quantite)


{ exit(VarDumper::dump($CartWithData));


$lc= new LigneCmd();
$lc->setQte($CartWithData['quantite']);
$lc->setIdProduit($p);
$lc->setIdCmd($order);
$lc->setTotalLigne($CartWithData['quantite']* $p->getPrix());
//exit(VarDumper::dump($lc));
    $em->persist($lc);
    $em->flush();





            }*/

        $session->clear();
        $cmdRepository = $em->getRepository('PanierBundle:Commande');
        $cmds=[
            'c'=>$cmdRepository->findBy(['id_Acheteur' =>$order->getIdAcheteur()]),
            'id'=>$order->getIdAcheteur()
        ];

        $lcRepository = $em->getRepository('PanierBundle:LigneCmd');

        $lcs=[
            'oussema'=>$lcRepository->findBy(['id_cmd' =>$order->getId()])
        ];
        
       // exit(VarDumper::dump($lcs));
       //exit(VarDumper::dump($cmds));

        return $this->render('@Panier/Panier/Creation.html.twig',array('cmds'=>$cmds,'lcs'=>$lcs));


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
                  'a'=> $CartWithData,
                   'tot'=> $total
               ]
        );


return new Response(
    $this->get('knp_snappy.pdf')->getOutputFromHtml($vars),200,array(
        'Content-type'=>'application/pdf',
        'Content-Disposition'=>'filename="CC.pdf"'
    )

);
    }




    public function callAction()
    {
        //returns an instance of Vresh\TwilioBundle\Service\TwilioWrapper
        $twilio = $this->get('twilio.api');

        $message = $twilio->account->messages->sendMessage(
            '+12057796619', // From a Twilio number in your account
            '+12125551234', // Text any number
            "Hello monkey!"
        );

        //get an instance of \Service_Twilio
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');

        return new Response($message->sid);
    }
    public function findLCAction($id){

    }

}

