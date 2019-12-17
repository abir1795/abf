<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 11/12/2019
 * Time: 18:33
 */

namespace App\Controller;


use App\Entity\BonLivrsn;
use App\Entity\BonlivrsnLine;
use App\Entity\Commande;
use App\Entity\CommandeHead;
use App\Repository\CommandeHeadRepository;
use App\Repository\CommandeRepository;
use App\Repository\StockERepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class AdminOrderHistory extends  AbstractController
{


    /**
     * @Route("/admin/orderHistory/index",name="app_orderHistory_index")
     */
    public function index(Request $request,PaginatorInterface $paginator,CommandeHeadRepository $commandeHeadRepository){
        $query=$commandeHeadRepository->findCommandeWithUserIfo();
        $GetrecenteCommande=$commandeHeadRepository->getRecentCommande();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );


        return $this->render("administrateur/orderHistory.html.twig",
            ["items"=>$pagination,
            "CountNonTraite"=> $CountNonTraite=$commandeHeadRepository->CountNonTraite()
            ]
            );
    }

    /**
     * @Route("/admin/commandes/ajax/{id}",name="app_adminorderAjax")
     */
    public function getDataToAjax($id,CommandeRepository $commandeRepository)
    {

        $query = $commandeRepository->FindCommandeHistoryAdmin($id);

//        $response = array();
//        foreach ($query as $items) {
//            $response[] = array(
//                'id' => $items->getId(),
//                'Produit'=>$items->getProductName(),
//                'prix'=>$items->getProductPrice(),
//                'qty'=>$items->getQty(),
//
//            );
//
//        }

        return new JsonResponse(json_encode($query));
    }


    /**
     * @Route("/admin/orderHistoriy/BLGenere/{id}",name="app_BL_Generate")
     */
    public function GenereteInvoice($id,CommandeRepository $commandeRepository,StockERepository $stockERepository,CommandeHeadRepository $commandeHeadRepository, \Swift_Mailer $mailer,UserRepository $userRepository){
       //Debut d'insertion data dans BNLIVRISON'
           $bonlivrsn=new BonLivrsn();
            $bonlivrsn->setCommandeId($id);
              $commande=$commandeRepository->findBy(['CommandeHead'=>$id]);
            $addressShippement=$commande['0']->getAddressShipement();
              $idCommande=$commande['0']->getId();
            $bonlivrsn->setAddress($addressShippement);
            $comandeHead=$commandeHeadRepository->find($id);
            $totalDoc=$comandeHead->getCommandeTotal();
            $bonlivrsn->setTotalDoc($totalDoc);
            $bonlivrsn->setDateCreation(new \DateTime());
            $idclient=$comandeHead->getUserId();
            $bonlivrsn->setClientId($idclient);
            $entitymanger=$this->getDoctrine()->getManager();

            $entitymanger->persist($bonlivrsn);


        $comandeHead->setStatus("Traitée");  //changement status

        //fin d'insertion data dans BnLivriosn


            $datacomande = $commandeRepository->findby(['CommandeHead' => $comandeHead]);


            //Insert data BonLivraison Line
        foreach ($datacomande as $item){
            $bnlivrsline=new BonlivrsnLine();
            $bnlivrsline->setBonLivrsn($bonlivrsn);
            $bnlivrsline->setProduitId($item->getProductId());
            $bnlivrsline->setProduitNom($item->getProductName());
            $bnlivrsline->setQty($item->getQty());
            $bnlivrsline->setPrix($item->getProductPrice());


            // Get Stock Id and Qty Dispo
            foreach ($stockERepository->findBy(['prdouits'=>$item->getProductId()]) as $data) {
                $stockdispo=$data->getQty();
                $idstock=$data->getId();
        }
            // fin get stock id and Qty Dispo


            $findstock=$stockERepository->find($idstock);
            $findstock->setQty($stockdispo-$item->getQty());

            $entitymanger->persist($bnlivrsline);
            $entitymanger->flush();
        }

        //end Insert Data BonLivraison Line


        //Email de confirmation


        $message = (new \Swift_Message('Chekout'))
            ->setFrom('notifmyproject@gmail.com')
            ->setTo($userRepository->find($idclient)->getEmail())
            // ->setCc('admin@amado.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/ConfirmationBL.html.twig',
                    ['name' => $this->getUser()->getNom(),
                        'totalCommande' => $bonlivrsn->getTotalDoc(),
                        'idBl' => $bonlivrsn->getId(),
                        'address' =>$bonlivrsn->getAddress(),
                        'idCommande'=>$bonlivrsn->getCommandeId(),
                        'datecreation'=>$bonlivrsn->getDateCreation(),
                        'itemProduit'=>$datacomande,
                    ]
                ),
                'text/html'
            );

        $mailer->send($message);

        //fin email









        return $this->redirectToRoute('app_orderHistory_index');
    }





    /**
     * @Route("/admin/orderHistoriy/CanceledOrder/{id}",name="app_Order_Canceled")
     */
    public function CanceledOrder($id,CommandeHeadRepository $commandeHeadRepository,UserRepository $userRepository,\Swift_Mailer $mailer){

        $comandeHead=$commandeHeadRepository->find($id);
        $idclient=$comandeHead->getUserId();
       $commandeHead= $commandeHeadRepository->find($id);
      $entitymanger= $this->getDoctrine()->getManager();
        $commandeHead->setStatus("Annuler");
        $entitymanger->flush();
        $message = (new \Swift_Message('Chekout'))
            ->setFrom('notifmyproject@gmail.com')
            ->setTo($userRepository->find($idclient)->getEmail())
            // ->setCc('admin@amado.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/ConfirmationBL.html.twig',
                    ['id'=>$id
                    ]
                ),
                'text/html'
            );

        $mailer->send($message);
        return $this->redirectToRoute('app_orderHistory_index',['id'=>$id]);
    }



}