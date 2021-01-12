<?php

namespace App\Form;

use App\Data\CommentData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCommentForm extends AbstractType
{

   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('comment', TextType::class, [
                'label' => false,
                'required'   => true,
                'attr' =>[
                    'placeholder' => 'Votre commentaire',
                    'class' => 'text'
                ],
            ]);
     }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => CommentData::class, 
            'method' => 'POST',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(){
        return '';
    }
}
?>