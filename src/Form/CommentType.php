<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CommentType extends AbstractType
{

    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Date',null,array( 'attr'=>array('style'=>'visibility:hidden'),'label'=>false))
            ->add('comment',TextareaType::class,array('attr' => array(
                'class' => 'form-control'
                
            ),'label'=>false))
            ->add('author',null,array('attr'=>array('style'=>'visibility:hidden'),'label'=>false,
                'data' => $this->security->getUser()
            ))
            /*->add('post',HiddenType::class,array(
        'data' => $postbyid
    ))*/

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class
        ]);
    }
}
