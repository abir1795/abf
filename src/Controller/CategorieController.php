<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 23/11/2019
 * Time: 16:14
 */

namespace App\Controller;




use App\Entity\Categorie;
use App\Form\InputCategoryType;
use App\Repository\CategorieRepository;
use App\Repository\CommandeHeadRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CategorieController extends AbstractController
{




        /**
     * @Route("/admin/categories/index",name="admin_categories")
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function adminCategoriesShow(PaginatorInterface $paginator,Request $request,CategorieRepository $categorieRepository,CommandeHeadRepository $commandeHeadRepository ){

        $CountNonTraite=$commandeHeadRepository->CountNonTraite();
        $categorie = new Categorie();
        $form=$this->createForm(InputCategoryType::class,$categorie);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid() ){
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

                $categorie->setImageUrl($newimage);
            }



            $categorie->setHOLD(false);
            $categorie->setDateCreation(new \Datetime());

            $manger=$this->getDoctrine()->getManager();

            $manger->persist($categorie);
            $manger->flush();
            return $this->redirectToRoute("admin_categories");


        }

        $query=$categorieRepository->findAll();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );
        return $this->render('administrateur/CategoriesAdmin.html.twig',
            [
                'dataerrors'=>(string)$form->getErrors(true, false),
                'form'=>$form->createView(),'items'=>$pagination,
                'CountNonTraite'=>$CountNonTraite
            ]);
    }

    /**
     * @Route("/admin/categories/update",name="admin_categories_updated")
     */
    public function updatedCategories(Request $request,CategorieRepository $categorieRepository){

        $entityManager = $this->getDoctrine()->getManager();

        $category = $categorieRepository->find($request->request->get('idid'));
        $HOLD=$request->request->get('HOLD')? true : false ;

        $category->setNameCategorie($request->request->get('editcategorie'));
        $category->setHOLD($HOLD);

        $entityManager->flush();


        return $this->redirectToRoute("admin_categories");
    }



}