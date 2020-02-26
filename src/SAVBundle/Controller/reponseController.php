<?php

namespace SAVBundle\Controller;

use SAVBundle\Entity\rec;
use SAVBundle\Entity\rep;
use SAVBundle\Form\repType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class reponseController extends Controller
{

    public function indexAction()
    {
        return $this->render('@SAV/reponse/index.html.twig');
    }
//
    public function showAction($id)
    {
        $var=$this->getDoctrine()->getManager()->getRepository(rep::class)->findBy(array('rec'=>$id));
        return $this->render('@SAV/reponse/show.html.twig',array('f'=>$var));
    }


    public function createRepAction($id,Request $request)
    {
        $var=$this->getDoctrine()->getManager()->getRepository(rec::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        $reclamation= new rep();

        $form = $this->createForm(repType::class, $reclamation);
        $form->handleRequest($request);



        if($form->isSubmitted()&& $form->isValid()){
            $reclamation->setRec($var);
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('sav_Show_Reponse',array('id'=>$id));



        }
        return $this->render('@SAV/reponse/add.html.twig',array('f' => $form->createView()));

    }
     public function deleteRepAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$this->getDoctrine()->getManager()->getRepository(rep::class)->find($id);
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("sav_Show_Reponse",array('id'=>$id));
    }





    public function updateRepAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamation=$this->getDoctrine()->getManager()->getRepository(rep::class)->find($id);

        $form = $this->createForm(repType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('sav_Show_Reponse');
        }
        return $this->render('@SAV/reponse/add.html.twig',array('f' => $form->createView()));

    }
}
