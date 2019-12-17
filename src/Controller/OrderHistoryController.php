<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 07/12/2019
 * Time: 19:07
 */

namespace App\Controller;


use App\Entity\Commande;
use App\Entity\CommandeHead;
use App\Repository\CommandeHeadRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderHistoryController extends AbstractController
{
    /**
     * @Route("/shop/orderhistory",name="app_OrderHistory")
     */
    public function index(Request$request,CommandeHeadRepository $commandeHeadRepository,PaginatorInterface $paginator){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $query=$commandeHeadRepository->getcommandebyDate($this->getUser()->getId());
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );




        return $this->render("UserInterface/OrderHistory.html.twig",['items'=>$pagination]);


    }
}