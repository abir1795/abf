<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 22/11/2019
 * Time: 19:56
 */

namespace App\Service\Cart;


use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartsServices
{
    private $session;
    private $productRepository;

    public function __construct(SessionInterface $session,ProduitRepository $productRepository)
    {
        $this->session=$session;
        $this->productRepository=$productRepository;
        //$session->clear();

    }

    public function add($id) {
        $panier=$this->session->get('panier',[]);
        if(!empty($panier[$id])){
            $panier[$id]++;
        }

        else {
            $panier[$id]=1;
        }

        $this->session->set('panier',$panier);
    }


    public function removerrow($id) {

        $panier=$this->session->get('panier',[]);
        if(!empty($panier[$id])){
            $panier[$id]--;
        }



        $this->session->set('panier',$panier);
    }



    public function remove($id){
        $panier=$this->session->get('panier',[]);
        if(!empty(($panier[$id]))){
            unset($panier[$id]);
        }
        $this->session->set('panier',$panier);
    }

    public function getFullData():array {
        $panier=$this->session->get('panier',[]);
        $panierwithdata=[];
        foreach ($panier as $id=>$quantity){
            $panierwithdata[]=[
                'product'=>$this->productRepository->find($id),
                'quantiy'=>$quantity


            ];

        }
        return $panierwithdata;
    }

    public function getTotal():float{

        $total=0;


        foreach ($this->getFullData() as $item){
            $total += $item['product']->getprix() * $item['quantiy'];



        }
        return $total;

    }


}