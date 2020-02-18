<?php
namespace  PanierBundle\Service\Cart ;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService{
    protected  $session;
public function __construct(SessionInterface $session)
{
    $this->session=$session;
}


    public function add(int $id){
        $panier = $this->session->get('panier',[]);
        if (!empty($panier[$id]))
        {
            $panier[$id]++;
        }
        else
        {
            $panier[$id]=1;
        }
//$panier=$this->getDoctrine()->getManager()->getRepository(Panier::class)->find($id);
//$panier[$id]=1;

        $this->session->set('panier',$panier);
    }



    public function remove(int $id){}
   /* public function getFullCart:array (){}
    public function getTotal(): float{}*/

}