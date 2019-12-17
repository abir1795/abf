<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 11/12/2019
 * Time: 09:31
 */

namespace App\Controller;


use App\Entity\StockE;
use App\Repository\CommandeHeadRepository;
use App\Repository\StockERepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class EntreeMarchandies extends AbstractController
{

    /**
     * @Route("/admin/stock/index",name="app_stock_index")
     */
    public function index(PaginatorInterface $paginator,StockERepository $stockERepository,Request $request,CommandeHeadRepository $commandeHeadRepository ){
        $stock=new StockE();
        $GetrecenteCommande=$commandeHeadRepository->getRecentCommande();
            $query=$stockERepository->findAllstock();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render("administrateur/StockAdmin.html.twig",

            ['items'=>$pagination,
                "CountNonTraite"=> $CountNonTraite=$commandeHeadRepository->CountNonTraite()
            ]);
    }

    /**
     * @Route("/admin/stock/update",name="app_stock_update")
     */
    public function updateStock(Request $request,StockERepository $stockERepository){
        $stockERepository = $stockERepository->find($request->request->get('idid'));
        $qtdispo=$request->request->get('qtys');
        $qtyadd=$request->request->get('qtadd');
        $stockERepository->setQty($qtyadd+$qtdispo);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();


        return $this->redirectToRoute('app_stock_index');
    }

}