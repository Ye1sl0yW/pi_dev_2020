<?php


namespace PointsBundle\Controller;


use PointsBundle\Entity\Portfolio;
use PointsBundle\Form\PortfolioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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


}