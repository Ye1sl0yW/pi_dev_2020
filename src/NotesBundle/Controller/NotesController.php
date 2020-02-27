<?php


namespace NotesBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NotesBundle\Entity\Note;
use Symfony\Component\HttpFoundation\Request;
use ProduitBundle\Entity\Produit;
use NotesBundle\Form\NoteType;
use MagasinBundle\Entity\Magasin;

class NotesController extends Controller
{

    public function ajoutNoteProduitAction(Request $request, $id){

        $em=$this->getDoctrine()->getManager();
        $note=new Note();
        $form=$this->createForm(NoteType::class,$note );

        $form=$form->handleRequest($request);
        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $note->setUserId($user=$this->getDoctrine()->getRepository('UserBundle:User')->find($this->get('security.token_storage')->getToken()->getUser()));
            $note->setType(0);
            $produit=$this->getDoctrine()->getRepository(Produit::class)->findBy(['id' =>$id])[0];

            $note->setProduitId($produit);
            $em -> persist($note);
            $em->flush();
            return $this->redirectToRoute('portfolios_afficher');
        }
        return $this->render('@Notes/Default/ajoutnote.html.twig',array('f'=> $form->createView()));
    }

    public function ajoutNoteMagasinAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);

        $form = $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $note->setUserId($user = $this->getDoctrine()->getRepository('UserBundle:User')->find($this->get('security.token_storage')->getToken()->getUser()));
            $note->setType(1);
            $magasin = $this->getDoctrine()->getRepository(Magasin::class)->findBy(['id' => $id])[0];

            $note->setMagasinId($magasin);
            $em->persist($note);
            $em->flush();
            return $this->redirectToRoute('portfolios_afficher');
        }
        return $this->render('@Notes/Default/ajoutnote.html.twig', array('f' => $form->createView()));
    }
        public function MoyenneMagasinAction(){

            $user=$this->getDoctrine()->getRepository('UserBundle:User')->find($this->get('security.token_storage')->getToken()->getUser());
            $magasin=$this->getDoctrine()->getRepository(Magasin::class)->findBy(['id_vendeur' =>$user]);

            $notes=$this->getDoctrine()->getRepository(Note::class)->findBy(['magasin_id' =>$magasin]);
            $total=0;
            $nb=0;
            foreach (
                $notes as $t
            )
            {

                $nb++;
                $total+=$t->getValue();
            }
            if ($nb)
            return $this->render('@Notes/Default/affichageNote.html.twig', array('tab'=>$notes,'total'=>$total/$nb));
            else  return $this->render('@Notes/Default/affichageNote.html.twig',array('tab'=>$notes));
    }
}