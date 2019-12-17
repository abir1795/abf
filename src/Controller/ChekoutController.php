<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 30/11/2019
 * Time: 23:56
 */

namespace App\Controller;
use App\Entity\Commande;
use App\Entity\CommandeHead;
use App\Repository\CommandeHeadRepository;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use App\Service\Cart\CartsServices;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ChekoutController extends AbstractController
{
    public function __construct(SessionInterface $session, ProduitRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        //$session->clear();

    }

    /**
     * @Route("/shop/chekout",name="chekout")
     */
    public function main(CartsServices $cartService)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        //dd( $this->session->get('panier'));
        return $this->render('UserInterface/Chkout.html.twig', [

            'items' => $cartService->getFullData(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/shop/chekout/add",name="chekout_add")
     */
    public function insertCommande(CartsServices $cartsServices, \Swift_Mailer $mailer)
    {
        //dd($cartsServices->getFullData());

        $comandehead = new CommandeHead();
        $entitymanger = $this->getDoctrine()->getManager();
        $comandehead->setUserId(($this->getUser()->getId()));
        $comandehead->setDateCreate(new  \DateTime());
        $comandehead->setCommandeTotal($cartsServices->getTotal());
        $comandehead->setStatus('Non Traite');
        $entitymanger->persist($comandehead);


            foreach ($cartsServices->getFullData() as $item) {

            $total = 0;
            $qtystock = $item['product']->getstockProduit()->getQty();
            if ($qtystock >= $item['quantiy']) {

                $entitymanger = $this->getDoctrine()->getManager();


                $total += $item['product']->getprix() * $item['quantiy'];


                $commande = new Commande();

                $commande->setUserId(($this->getUser()->getId()));
                $commande->setProductId($item['product']->getid());
                $commande->setProductName($item['product']->getDescription());
                $commande->setProductPrice($item['product']->getprix());
                $commande->setAddressShipement($this->getUser()->getaddress());
                $commande->setQty($item['quantiy']);
                $commande->setDateCreation(new \DateTime());
                $commande->setTotalLine($total);
                $commande->setTotalCommande($cartsServices->getTotal());
                $commande->setCommandeHead($comandehead);

                $entitymanger->persist($commande);
                $entitymanger->flush();



            }

        }
        $message = (new \Swift_Message('Chekout'))
            ->setFrom('notifmyproject@gmail.com')
            ->setTo($this->getUser()->getEmail())
            //->setCc('admin@amado.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    ['name' => $this->getUser()->getNom(),
                        'totalCommande' => $cartsServices->getTotal(),
                        'id' => $comandehead->getId(),
                        'address' => $this->getUser()->getaddress(),
                    ]
                ),
                'text/html'
            );

        $mailer->send($message);
        $this->session->clear();

        return $this->redirectToRoute('app_OrderHistory');
    }

    /**
     * @Route("/shope/order/chek/ajax/{id}",name="app_getajax_orderhistory")
     */
    public function getDataToAjax($id, CommandeRepository $commande)
    {

        $commandes = $commande->findBy(['CommandeHead' => $id]);

        return $this->render("UserInterface/OrderHistoryDetails.html.twig",
            ['items'=>$commandes]
            );

//        $response = array();
//        foreach ($commandes as $items) {
//            $response[] = array(
//                'id' => $items->getId(),
//                'Produit'=>$items->getProductName(),
//                'prix'=>$items->getProductPrice(),
//                'qty'=>$items->getQty(),
//                ''
//
//            );
//
//        }
//        return new JsonResponse(json_encode($response));
    }
}