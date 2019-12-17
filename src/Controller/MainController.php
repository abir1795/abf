<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 26/11/2019
 * Time: 14:42
 */

namespace App\Controller;


use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class MainController extends  AbstractController
{

    /**
     * @Route("/",name="index")
     */
        public function index(CategorieRepository $categorieRepository){

            return $this->render("UserInterface/index.html.twig",
                [
                    'items'=>$categorieRepository->findBy(
                        [
                            'HOLD' => false,
                        ]),

                ]
                );
        }

    /**
     * @Route("/Shop/Produit/{id}",name="Shop_ShowProduitAll")
     */
        public function showProduitParCategorie(Request $request,$id,PaginatorInterface $paginator,ProduitRepository $produitRepository,CategorieRepository $categorieRepository){

            $query=$produitRepository->findBy(
                [
                    'category'=>$id,
                    'HOLD' => false,
                ]);
            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                2 /*limit per page*/
            );


            return $this->render("UserInterface/Product/index.html.twig",
            [
            'items'=>$pagination,
                'categories' => $categorieRepository->findBy(
                    [
                        'HOLD'=>false
                    ]
                ),
                'idcategorie' => $id

                ]

            );
        }
}