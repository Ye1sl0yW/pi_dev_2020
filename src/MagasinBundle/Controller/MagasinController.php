<?php

namespace MagasinBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MagasinBundle\Entity\Magasin;
use MagasinBundle\Form\MagasinType;
use MagasinBundle\Service\MagasinService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Repository\UserRepository;


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

    public function detailsAction($id)
    {
        $ms = $this->get(MagasinService::class);
        $magasin = $ms->refreshMagasin($id);
        $pieChart = $ms->pieChartOfNumberOfProductsByCategory($id);
        //return $this->render('@Magasin/Magasin/test.html.twig',array('piechart'=>$pieChart));
        return $this->render('@Magasin/Magasin/details.html.twig',array('data'=>$magasin,'piechart'=>$pieChart));
    }

    public function createMagasinAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $magasin = new Magasin();
        $magasin->setTailleStock(0);

        $form = $this->createForm(MagasinType::class, $magasin);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em->persist($magasin);
            $em->flush();

            if($magasin->getIdVendeur() !== null)
            {
                $id_vendeur = $magasin->getIdVendeur()->getId();
                $this->get(MagasinService::class)->addManager($magasin->getId(),$id_vendeur);
            }
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

            $id_vendeur = $magasin->getIdVendeur()->getId();
            $this->get(MagasinService::class)->addManager($magasin->getId(),$id_vendeur);

            return $this->redirectToRoute('magasin_homepage');
        }
        return $this->render('@Magasin/Magasin/form_magasin.html.twig',array('f' => $form->createView()));

    }

}
