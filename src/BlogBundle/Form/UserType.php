<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', TextType::class, array(
                    'label' => 'Nombre',
                    "required" => "required",
                    "attr" => array(
                        "class" => "form-name form-control"
                )))
                ->add('surname', TextType::class, array(
                    'label' => 'Apellidos',
                    "required" => "required",
                    "attr" => array(
                        "class" => "form-surname form-control"
                )))
                ->add('email', EmailType::class, array(
                    "required" => "required",
                    "attr" => array(
                        "class" => "form-email form-control"
                )))
                ->add('password', RepeatedType::class, array(
                    'label' => 'Contraseña',
                    'type' => PasswordType::class,
                    'invalid_message' => 'Las contraseñas son incorrectas.',
                    'options' => array('attr' => array('class' => 'form-password form-control')),
                    'required' => true,
                    'first_options'  => array('label' => 'Contraseña'),
                    'second_options' => array('label' => 'Repita Contraseña'),
                    "required" => "required"
                ))
                ->add('Guardar', SubmitType::class, array(
                    "attr" => array(
                        "class" => "form-submit btn btn-success"
                )));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'blogbundle_user';
    }

}
