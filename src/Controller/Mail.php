<?php
/**
 * Created by PhpStorm.
 * User: Abir
 * Date: 02/12/2019
 * Time: 15:03
 */

namespace App\Controller;
use App\Entity\CommandeHead;
use App\Service\Cart\CartsServices;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class Mail extends AbstractController
{

    /**
     * @Route("/add/mail/{id}",name="app_mailer")
     */
    public function index($id,\Swift_Mailer $mailer)
    {

        $cartservice =new CartsServices();
        $message = (new \Swift_Message('Chekout'))
            ->setFrom('notifmyproject@gmail.com')
            ->setTo($this->getUser()->Email())
            ->setCc('amehdi@sofapur.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    ['name' => $this->getUser()->getId(),
                        'totalCommande' =>$cartservice->getTotal(),
                        'id'=>$id
                        ]
                ),
                'text/html'
            );

        $mailer->send($message);


        return $this->render("UserInterface/OrderHistory.html.twig"
        );
    }

}
