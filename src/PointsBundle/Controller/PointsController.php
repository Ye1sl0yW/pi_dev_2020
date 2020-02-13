<?php


namespace PointsBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PointsBundle\Entity\Ticket;
use PointsBundle\Entity\Portfolio;
use PointsBundle\Form\TicketType;
use PointsBundle\Form\PortfolioType;
use Symfony\Component\HttpFoundation\Request;


class PointsController extends Controller
{

    public function ajoutTicketAction(Request $request)
    {

        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form = $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
            return $this->redirectToRoute('portfolios_afficher');
        }
        return $this->render('@Points/Ticket/ajoutticket.html.twig', array('f' => $form->createView()));
    }

    public function afficherTicketAction($id)
    {

        $ticket = $this->getDoctrine()->getRepository(Ticket::class)->findBy(array('portfolio'=>$id));
        return $this->render('@Points/Ticket/affichageTicket.html.twig', array('tab' => $ticket));
    }

    public function supprimerTicketAction($id)
    {


            $em=$this->getDoctrine()->getManager();
            $ticket=$this->getDoctrine()->getRepository(Ticket::class)->find($id);
            $em->remove($ticket);
            $em->flush();
            return $this->redirectToRoute("portfolios_afficher");

    }

    public function modifierTicketAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $ticket=$this->getDoctrine()->getRepository(Ticket::class)->find($id);

        $form=$this->createForm(TicketType::class,$ticket );

        $form=$form->handleRequest($request);
        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em -> persist($ticket);
            $em->flush();
            return $this->redirectToRoute('portfolios_afficher');
        }
        return $this->render('@Points/Ticket/ajoutticket.html.twig',array('f'=> $form->createView()));

    }

}