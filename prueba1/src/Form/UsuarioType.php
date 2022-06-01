<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('apellidos')
            //con esta clase integer hacemos que solo se puedan
            //meter números
            ->add('numero', IntegerType::class, [
                'constraints' => [
                    new Range([
                        'min' => 100,
                        'max' => 200,
                        'notInRangeMessage' => 'El valor debe estar entre 100 y 200'
                    ])
                ]
            ])
            ->add('Selector', ChoiceType::class, [
                'choices' => [
                    'opcion 1 ' => 1,
                    'opcion 2 ' => 2,
                    'opcion 3' => 3,
                ],
                'multiple' => true, //para poder tener varias opciones
                'expanded' => true, //para poder ver todas las opciones juntas
                //se pueden combinar ambos
            ])
            ->add('rango', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ])
            ->add('archivo', FileType::class, [
                'required' => false
            ])
            ->add('fechas', DateIntervalType::class);
    }
}
