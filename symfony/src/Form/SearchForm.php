<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Majors;
use App\Entity\Universities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{

   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('filiere', ChoiceType::class, [
                'label' => false,
                'required'   => true,
                'multiple' => false,
                'choices' => [
                    'IR & SEP' => 'all',
                    'IR' => 'IR',
                    'SEP' => 'sep',
                ],
                'attr' =>[
                    'class' => 'custom-select'
                ]
            ])
            ->add('nomUniv', TextType::class, [
                'label' => false,
                'required'   => false,
                'attr' =>[
                    'placeholder' => 'Recherche par nom',
                    'class' => 'custom-select'
                ],
            ])

            ->add('langue', ChoiceType::class, [
                'label' => false,
                'required'   => true,
                'multiple' => false,
                'choices' => [
                    'LV1 & LV2' => 'all',
					'LV1' => 'Anglais',
					'LV2 Espagnol' => 'Espagnol',
					'LV2 Allemand' => 'Allemand',
                ],
                'attr' =>[
                    'class' => 'custom-select'
                ],
            ])
           ;
     }       

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => SearchData::class, 
            'method' => 'POST',
            'csrf_protection' => false

        ]);
    }

    public function getBlockPrefix(){
        return '';
    }
}
?>