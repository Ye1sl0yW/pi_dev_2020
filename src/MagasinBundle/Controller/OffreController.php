<?php

namespace MagasinBundle\Controller;

use MagasinBundle\Entity\Magasin;
use MagasinBundle\Entity\Offre;
use MagasinBundle\Form\MagasinType;
use MagasinBundle\Form\OffreType;
use MagasinBundle\Service\MagasinService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class OffreController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Magasin/Offre/index.html.twig');
    }

    public function showAction()
    {
        $var=$this->getDoctrine()->getManager()->getRepository(Offre::class)->findAll();
        return $this->render('@Magasin/Offre/index.html.twig',array('data'=>$var));
    }


    public function createOffreAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $offre = new Offre();

        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('offre_homepage');
        }
        return $this->render('@Magasin/Offre/form_offre.html.twig',array('f' => $form->createView()));

    }

    public function deleteOffreAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $offre=$this->getDoctrine()->getManager()->getRepository(Offre::class)->find($id);
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute("offre_homepage");
    }

    public function updateOffreAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $offre=$this->getDoctrine()->getManager()->getRepository(Offre::class)->find($id);

        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('offre_homepage');
        }
        return $this->render('@Magasin/Offre/form_offre.html.twig',array('f' => $form->createView()));

    }

    public function showOffersOfThisShopAction($id)
    {
        $data=$this->get(MagasinService::class)->findAllOffersByShop($id);
        return $this->render('@Magasin/Offre/offers.html.twig',array('data'=>$data));
    }


}
