<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\Categorie;
use ProduitBundle\Entity\Produit;
use ProduitBundle\Form\CategorieType;
use ProduitBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProduitController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Produit/Produit/index.html.twig');
    }
    public function afficherAction()
    {
        $produit=$this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        return $this->render('@Produit/Produit/index.html.twig',array('data'=>$produit));

    }

    public function AjouterProduitAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit= new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('produit_homepage');
        }
        return $this->render('@Produit/Produit/form_produit.html.twig',array('f' => $form->createView()));

    }

    public function SupprimerProduitAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$this->getDoctrine()->getRepository(Produit::class)->find($id);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("produit_homepage");
    }

    public function modifierProduitAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $produit=$this->getDoctrine()->getRepository(Produit::class)->find($id);

        $form=$this->createForm(ProduitType::class,$produit );

        $form=$form->handleRequest($request);
        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em -> persist($produit);
            $em->flush();
            return $this->redirectToRoute('produit_homepage');
        }
        return $this->render('@Produit/Produit/form_produit.html.twig',array('f'=> $form->createView()));

    }



    public function afficherCategorieAction()
    {
        $categorie=$this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        return $this->render('@Produit/Categorie/index.html.twig',array('data'=>$categorie));

    }

    public function AjouterCategorieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie= new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('categorie_homepage');
        }
        return $this->render('@Produit/Categorie/form_categorie.html.twig',array('f' => $form->createView()));

    }

    public function SupprimerCategorieAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$this->getDoctrine()->getRepository(Categorie::class)->find($id);
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("categorie_homepage");
    }

    public function modifierCategorieAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $categorie=$this->getDoctrine()->getRepository(Categorie::class)->find($id);

        $form=$this->createForm(CategorieType::class,$categorie );

        $form=$form->handleRequest($request);
        if($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em -> persist($categorie);
            $em->flush();
            return $this->redirectToRoute('categorie_homepage');
        }
        return $this->render('@Produit/Categorie/form_categorie.html.twig',array('f'=> $form->createView()));

    }

}
