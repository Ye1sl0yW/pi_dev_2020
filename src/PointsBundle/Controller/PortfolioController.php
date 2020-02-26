<?php


namespace PointsBundle\Controller;


use PointsBundle\Entity\Portfolio;
use PointsBundle\Form\PortfolioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;
use UserBundle\Entity\User;
use PointsBundle\Entity\Ticket;

class PortfolioController extends Controller
{

    public function afficherPortfolioAction()
    {

        $portfolio = $this->getDoctrine()->getRepository(Portfolio::class)->findAll();
        return $this->render('@Points/Portfolio/affichagePortfolio.html.twig', array('tab' => $portfolio));
    }

    public function ajouterPortfolioAction(Request $request)
    {

        $portfolio = new Portfolio();
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($portfolio);
            $em->flush();
            return $this->redirectToRoute('portfolios_afficher');
        }
        return $this->render('@Points/Portfolio/ajoutPortfolio.html.twig', array('f' => $form->createView()));
    }

    public function modifierPortfolioAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $portfolio=$this->getDoctrine()->getRepository(Portfolio::class)->find($id);

        $form=$this->createForm(PortfolioType::class,$portfolio );

        $form=$form->handleRequest($request);
        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em -> persist($portfolio);
            $em->flush();
            return $this->redirectToRoute('portfolios_afficher');
        }
        return $this->render('@Points/Portfolio/ajoutPortfolio.html.twig',array('f'=> $form->createView()));

    }

    public function supprimerPortfolioAction($id)
    {


        $em=$this->getDoctrine()->getManager();
        $portfolio=$this->getDoctrine()->getRepository(Portfolio::class)->find($id);
        $em->remove($portfolio);
        $em->flush();
        return $this->redirectToRoute("portfolios_afficher");

    }


    public function myPointsAction(){

        $user=$this->getDoctrine()->getRepository('UserBundle:User')->find($this->get('security.token_storage')->getToken()->getUser());

        $portfolio=$this->getDoctrine()->getRepository(Portfolio::class)->findBy(['id' =>$user->getPortfolio()])[0];

        $tickets=$this->getDoctrine()->getRepository(Ticket::class)->findBy(['portfolio' =>$portfolio->getId()]);
        $total=0;
        foreach (
            $tickets as $t
        )
        {
            $total+=$t->getMontant();
        }
        return $this->render('@Points/Ticket/affichageTicketUser.html.twig', array('tab' => $tickets,'total'=>$total));
    }


}