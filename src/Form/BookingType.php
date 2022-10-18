<?php

namespace App\Form;

use App\Entity\BookingRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'=>'Название',
                'attr'=> [
                    'class'=>'input',
                    'autofocus'=>'autofocus',
                    ],
                ])
            ->add('description', TextType::class, [
                'label'=>'Описание',
                'attr'=> [
                    'class'=>'input',
                    'autofocus'=>'autofocus',
                ],
            ])
            ->add('date_start', DateTimeType::class, [
                'label'=>'Начало',
                'date_widget'=>'single_text',
                'attr'=>[
                    'class'=>'datetimepicker'
                ],
            ])
            ->add('date_finish', DateTimeType::class, [
                'label'=>'Окончание',
                'date_widget'=>'single_text',
                'attr'=>[
                    'class'=>'datetimepicker'
                ],
            ])
            ->add('full_name', TextType::class, [
                'label'=>'Фамилия Имя Отчество',
                'attr'=> [
                    'class'=>'input',
                    'autofocus'=>'autofocus',
                ],
            ])
            ->add('phone', TextType::class, [
                'label'=> "Телефон",
                'attr'=> [
                    'class'=>'input',
                    'autofocus'=>'autofocus',
                ],
            ])
            ->add('id_room', TextType::class, [
                'label'=> "Идентификатор помещения",
                'attr'=> [
                    'class'=>'input',
                    'autofocus'=>'autofocus',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookingRequest::class,
        ]);
    }
}
