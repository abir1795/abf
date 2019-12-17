<?php
/**
 * Created by PhpStorm.
 * User: Abir
 * Date: 13/12/2019
 * Time: 21:23
 */

namespace App\Controller;


use App\Repository\CommandeHeadRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class adminhome extends  AbstractController
{

    /**
     * @Route("/admin/home/index",name="app_admin_index")
     */
    public function  index(CommandeHeadRepository $commandeHeadRepository,PaginatorInterface $paginator,Request $request)
    {
        $total=$commandeHeadRepository->countCommandeHead();
        $caCommande=$commandeHeadRepository->caCommande();
        $commandetraite=$commandeHeadRepository->CountCommandeTraitee();
        $CountNonTraite=$commandeHeadRepository->CountNonTraite();
        $GetrecenteCommande=$commandeHeadRepository->getRecentCommande();

        $query=$GetrecenteCommande;
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render("administrateur\home.html.twig",[
            'TotalCommande'=>$total,
            'caCommande'=>$caCommande,
            'commandetraite'=>$commandetraite,
            'CountNonTraite'=>$CountNonTraite,
            'GetrecenteCommande'=>$pagination

            ]);
    }

}
