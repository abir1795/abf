<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class InputProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Description',TextType::class,['label'=>'Titre Produit'])
            ->add('Produit_Code',TextType::class)
            ->add('prix',MoneyType::class)
            ->add('DescriptionText',TextareaType::class,['label'=>'Description'])
            ->add('Category', EntityType::class,
                [
                'class'=>Categorie::class,
                'choice_label'=>'NameCategorie',
                'placeholder' => 'Chosiri une Categories',
            ])
            ->add('ImageUrl',FileType::class,[
                'label' => 'Image Produit',
                'mapped' =>false,
                'constraints' => [
                    new File([
                        'maxSize' => '1M',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please inset an image Type (JPG,PNG,GIF)',
                    ])
                ],
            ])
            ->add('Save',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
