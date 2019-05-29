<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Post3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title')
            ->add('Date',null,array( 'attr'=>array('style'=>'visibility:hidden'),'label'=>false))
            ->add('Data')
            ->add('topic',null,array('attr'=>array('style'=>'visibility:hidden'),'label'=>false,
            'data' => $options['topic_id']
            ))
            ->add('author',null,array('attr'=>array('style'=>'visibility:hidden'),'label'=>false,
                'data' => $this->security->getUser()
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
