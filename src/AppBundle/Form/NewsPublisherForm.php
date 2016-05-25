<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/05/16
 * Time: 17:53
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewsPublisherForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('title', TextType::class, array('label' => false, 'attr' => array(
                'placeholder' => 'Title'
            ),
                'required' => true))
            ->add('text', TextareaType::class, array('label' => false, 'attr' => array(
                'placeholder' => 'Text'
            ),
                'required' => true))
            ->add('Publish', SubmitType::class, array(
                'label' => 'Publish')
            )
        ;
    }

    public function getName()
    {
        return 'NewsPublisher';
    }

}