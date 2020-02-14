<?php

namespace MagasinBundle\Controller;

use MagasinBundle\Entity\Magasin;
use MagasinBundle\Form\MagasinType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MagasinController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Magasin/Magasin/index.html.twig');
    }

    public function showAction()
    {
        $var=$this->getDoctrine()->getManager()->getRepository(Magasin::class)->findAll();
        return $this->render('@Magasin/Magasin/index.html.twig',array('data'=>$var));
    }


    public function createMagasinAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $magasin = new Magasin();

        $form = $this->createForm(MagasinType::class, $magasin);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($magasin);
            $em->flush();
            return $this->redirectToRoute('magasin_homepage');
        }
        return $this->render('@Magasin/Magasin/form_magasin.html.twig',array('f' => $form->createView()));

    }

    public function deleteMagasinAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $magasin=$this->getDoctrine()->getManager()->getRepository(Magasin::class)->find($id);
        $em->remove($magasin);
        $em->flush();
        return $this->redirectToRoute("magasin_homepage");
    }

    public function updateMagasinAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $magasin=$this->getDoctrine()->getManager()->getRepository(Magasin::class)->find($id);

        $form = $this->createForm(MagasinType::class, $magasin);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($magasin);
            $em->flush();
            return $this->redirectToRoute('magasin_homepage');
        }
        return $this->render('@Magasin/Magasin/form_magasin.html.twig',array('f' => $form->createView()));

    }

}
