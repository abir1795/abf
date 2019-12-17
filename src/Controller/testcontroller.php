<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 29/11/2019
 * Time: 08:29
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class testcontroller extends AbstractController
{

    /**
     * @Route("/test",name="test")
     */
    public function test(){
       return $this->render("emails/ConfirmationBL.html.twig");

    }

}