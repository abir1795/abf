<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 23/11/2019
 * Time: 20:05
 */

namespace App\Controller;
use App\Entity\Categorie;
use App\Entity\Produit;
use App\Entity\StockE;
use App\Form\InputProduitType;
use App\Form\UpdateImagePRoduitInAdminType;
use App\Repository\CategorieRepository;
use App\Repository\CommandeHeadRepository;
use App\Repository\ProduitRepository;


use Knp\Component\Pager\Pagination\PaginationInterface;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class ProduitController extends AbstractController
{

    /**
     * @Route("/admin/Produits/index",name="admin_Produits")
     */
      public function ShowAdminProduit(PaginatorInterface $paginator ,Request $request,ProduitRepository $produitRepository,CategorieRepository $categorieRepository,CommandeHeadRepository $commandeHeadRepository){
          $produit=new Produit();
        $form=$this->createForm(InputProduitType::class,$produit);
          $CountNonTraite=$commandeHeadRepository->CountNonTraite();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form ->isValid()){

            $ImageFile = $form['ImageUrl']->getData();
            if($ImageFile){
                $originalImageName = pathinfo($ImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
                    $originalImageName);
                $newimage= $safeFilename.'-'.uniqid().'.'.$ImageFile->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $ImageFile->move(
                        $this->getParameter('image_directory'),
                        $newimage
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $produit->setImageUrl($newimage);
            }

            $stocke=new StockE();

            $produit->setHOLD(false);
            //dd($produit);
            $stocke->setPrdouits($produit);
            $stocke->setQty(0);
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($stocke);
            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute("admin_Produits");


        }



        $query=$produitRepository->findAll();
          $pagination = $paginator->paginate(
              $query, /* query NOT result */
              $request->query->getInt('page', 1), /*page number*/
              5 /*limit per page*/
          );

        //dd($pagination);
      return $this->render("administrateur/produitsAdmin.html.twig",[
          'dataerrors'=>(string)$form->getErrors(true, false),
          'form'=>$form->createView(),
         'categories'=>$categorieRepository->findAll(),
         'items'=>$pagination,
              'CountNonTraite'=>$CountNonTraite

          ]
      );

   }


    /**
     * @Route("/admin/produit/update",name="admin_produit_update")
     */
   public function EditProduit(Request $request,ProduitRepository $produitRepository,CategorieRepository $categorieRepository){
   $HOLD=$request->request->get('HOLD')? true : false ;

       $entityManager = $this->getDoctrine()->getManager();
       $product = $produitRepository->find($request->request->get('idid'));
       $category = $categorieRepository->find($request->request->get('categories'));
       $product->setDescription($request->request->get('editnameproduit'));
       $product->setDescriptionText($request->request->get('description'));
//dd($request->request);




            $product->setCategory($category);
            $product->setPrix($request->request->get('PrixNameEdit'));
            $product->setHOLD($HOLD);
       $entityManager->flush();

          return $this->redirectToRoute("admin_Produits");
   }


    /**
     * @Route("/admin/produit/updateImage/{id}",name="admin_produit_updateImage")
     */
   public function UpdateImageMiseAjours($id,Request $request,ProduitRepository $produitRepository){

       $entityManager = $this->getDoctrine()->getManager();
       $product = $produitRepository->find($id);
        $form=$this->createForm(UpdateImagePRoduitInAdminType::class);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid() ){
           $ImageFile = $form['ImageUrl']->getData();

           if($ImageFile){
               $originalImageName = pathinfo($ImageFile->getClientOriginalName(), PATHINFO_FILENAME);
               $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
                   $originalImageName);
               $newimage= $safeFilename.'-'.uniqid().'.'.$ImageFile->guessExtension();
               // Move the file to the directory where brochures are stored
               try {
                   $ImageFile->move(
                       $this->getParameter('image_directory'),
                       $newimage
                   );
               } catch (FileException $e) {
                   // ... handle exception if something happens during file upload
               }

               $product->setImageUrl($newimage);
           }

           $entityManager->flush();
           return $this->redirectToRoute("admin_Produits");

       }




        return $this->render("administrateur/forms/UpdateImageProduit.html.twig",
            ['form'=>$form->createView()]);
   }



}