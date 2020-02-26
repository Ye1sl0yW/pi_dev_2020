<?php

namespace ProduitBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
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
        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->findAll();
        return $this->render('@Produit/Produit/index.html.twig', array('data' => $produit));

    }

    public function AjouterProduitAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = new Produit();
        $produit->setImageName("default_image.png");
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isValid() and $form->isSubmitted()) {
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('produit_homepage');
        }
        return $this->render('@Produit/Produit/form_produit.html.twig', array('f' => $form->createView()));

    }

    public function SupprimerProduitAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("produit_homepage");
    }

    public function modifierProduitAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        $form = $this->createForm(ProduitType::class, $produit);

        $form = $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('produit_homepage');
        }
        return $this->render('@Produit/Produit/form_produit.html.twig', array('f' => $form->createView()));

    }


    public function afficherCategorieAction()
    {
        $categorie = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        return $this->render('@Produit/Categorie/index.html.twig', array('data' => $categorie));

    }

    public function AjouterCategorieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('categorie_homepage');
        }
        return $this->render('@Produit/Categorie/form_categorie.html.twig', array('f' => $form->createView()));

    }

    public function SupprimerCategorieAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("categorie_homepage");
    }

    public function modifierCategorieAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->find($id);

        $form = $this->createForm(CategorieType::class, $categorie);

        $form = $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('categorie_homepage');
        }
        return $this->render('@Produit/Categorie/form_categorie.html.twig', array('f' => $form->createView()));

    }

    public function frontPageAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produit = array();
        while (sizeof($produit) < 7) {
            $rd = rand(1, 100);

            $item = $this->getDoctrine()->getRepository(Produit::class)->find($rd);
            if (($item !== null) && ($item->getImageName() !== null) && (in_array($item, $produit)) == false) {
                array_push($produit, $item);
            }

        }
        $cat = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('@Produit/Produit/frontPage.html.twig', array('produit' => $produit, 'categories' => $cat));
//TODO Randomize product ajouter lien detail produit
    }


    public function detailProduitAction($id)
    {
        $produit = $this->getDoctrine()->getManager()->getRepository(Produit::class)->find($id);
        return $this->render('@Produit/Produit/product.html.twig', array('produit' => $produit));

    }

    public function findAllProductsAndCategoryAction($category)
    {
        $value = 0;
        $X=0;
        $cat = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $t = $this->getDoctrine()->getRepository(Categorie::class)->find($category);
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        $res = new Arraycollection();

        foreach ($produits as $produit) {
            if ($produit->getIdCategorie()->contains($t)) {
                $value += $produit->getPrix();
            }
        }
        foreach ($produits as $produit) {
            if ($produit->getIdCategorie()->contains($t)) {
                $res->add($produit);
            }
        }
        if ($res->count() === 0)
        {
            $X=0;
        }else{
            $X=$value / $res->count();
            $X = number_format($X,2);

        }
        return $this->render('@Produit/Produit/frontPage.html.twig', array('produit' => $res, 'categories' => $cat, 'L' => $res->count()
        , 'PM' =>$X ));
    }

    function searchbypriceAction(Request $request )
    {
        $prixmin = 0;
        $prixmax = 0;
        $X=0;
        $cat = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        $res = new Arraycollection();

        if ($request->isMethod('POST'))
        {
            $prixmin=($request->get('prixmin'));
            $prixmax=($request->get('prixmax'));

            foreach ($produits as $produit)
            {
                    if ($prixmin < $produit->getPrix() &&  $prixmax > $produit->getPrix())
                    {
                        $res->add($produit);
                    }
            }
        }

        return $this->render('@Produit/Produit/frontPage.html.twig', array('produit' => $res, 'categories' => $cat
        , 'L' => $res->count()
        , 'PM' =>$X ));
    }


}