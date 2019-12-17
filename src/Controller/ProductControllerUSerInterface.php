<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 27/11/2019
 * Time: 11:42
 */

namespace App\Controller;


use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductControllerUSerInterface extends AbstractController
{
    /**
     * @Route("/shop/product/info/{id}",name="UserInterface_Product_Info")
     */
    public function index($id,ProduitRepository $produitRepository,CategorieRepository $categorieRepository){
        $data=$produitRepository->findBy([
            'id'=>$id
        ]);

        return $this->render('UserInterface/Product/ProductInfo.html.twig',
        [
            'items'=>$data
        ]
        );
    }
}