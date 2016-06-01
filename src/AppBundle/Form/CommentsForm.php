<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 01/06/16
 * Time: 22:01
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('name', TextType::class, array('label' => false, 'attr' => array(
                'placeholder' => 'Name'
            ),
                'required' => true))
            ->add('text', TextareaType::class, array('label' => false, 'attr' => array(
                'placeholder' => 'Text',
                'rows' => '5',
                'style' => 'resize: none;'
            ),
                'required' => true))
            ->add('comment', SubmitType::class, array(
                    'label' => 'Comment',
                    'attr' => ['class' => 'btn-info center-block'])
            )
        ;
    }

    public function getName()
    {
        return 'Comments';
    }

}