<?php
/**
 * Created by PhpStorm.
 * User: Abir
 * Date: 29/11/2019
 * Time: 19:18
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class RegistrationController extends AbstractController
{


    /**
     * @Route("/inscription",name="inscription")
     */
    public function FormRegistration(Request $request,UserPasswordEncoderInterface $passwordEncoder){

        $user = new User();
        $form=$this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(['Client']);

            // 4) save the User!
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute("app_login");

        }


        return $this->render("security/registration.html.twig",['form'=>$form->createView()]);

    }

}
