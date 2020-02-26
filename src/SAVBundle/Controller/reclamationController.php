<?php

namespace SAVBundle\Controller;

use ReclamationBundle\Entity\Reponse;
use SAVBundle\Entity\rec;
use SAVBundle\Form\recType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class reclamationController extends Controller
{

    public function indexAction()
    {
        return $this->render('@SAV/reclamation/index.html.twig');
    }
//
    public function showAction()
    {
        $var=$this->getDoctrine()->getManager()->getRepository(rec::class)->findAll();
        return $this->render('@SAV/reclamation/show.html.twig',array('f'=>$var));
    }

    public function showFrontAction()
    {
        $var=$this->getDoctrine()->getManager()->getRepository(rec::class)->findAll();
        return $this->render('@SAV/reclamation/home.html.twig',array('f'=>$var));
    }


    public function createRecAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $reclamation= new rec();

        $form = $this->createForm(recType::class, $reclamation);
        $form->handleRequest($request);



        if($form->isSubmitted()&& $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('sav_home_Reclamation');



        }
        return $this->render('@SAV/reclamation/add.html.twig',array('f' => $form->createView()));

    }











    public function deleteRecAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$this->getDoctrine()->getManager()->getRepository(rec::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("sav_Show_Reclamation");
    }





    public function updateRecAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$this->getDoctrine()->getManager()->getRepository(rec::class)->find($id);

        $form = $this->createForm(recType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('sav_Show_Reclamation');
        }
        return $this->render('@SAV/reclamation/add.html.twig',array('f' => $form->createView()));

    }
    public function rechercheReclamationAction(Request $request)
    {
        if($request->isMethod("POST"))
        {
            $reclamation = $this->getDoctrine()->getRepository(rec::class)->findBy(array('type' =>$request->get("typereclamation")));
        return $this->render('@SAV/reclamation/home.html.twig',array('f' => $reclamation));
        }
    }

}
