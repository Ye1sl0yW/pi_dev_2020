<?php


namespace NotesBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NotesBundle\Entity\Note;
use Symfony\Component\HttpFoundation\Request;

use NotesBundle\Form\NoteType;

class NotesController extends Controller
{

    public function ajoutNoteProduitAction(Request $request, $id){

        $em=$this->getDoctrine()->getManager();
        $note=new Note();
        $form=$this->createForm(NoteType::class,$note );

        $form=$form->handleRequest($request);
        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em -> persist($note);
            $em->flush();
            return $this->redirectToRoute('portfolios_afficher');
        }
        return $this->render('@Notes/Default/ajoutnote.html.twig',array('f'=> $form->createView()));
    }
}