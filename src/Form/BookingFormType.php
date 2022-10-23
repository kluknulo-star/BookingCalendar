<?php

namespace App\Form;

use App\Entity\BookingRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BookingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Название',
                'attr' => [
                    'class' => 'input mb-2',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Описание',
                'attr' => [
                    'class' => 'input mb-2',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('date_start', DateTimeType::class, [
                'label' => 'Начало',
                'date_widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker mb-2',
                ],
            ])
            ->add('date_finish', DateTimeType::class, [
                'label' => 'Окончание',
                'date_widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimepicker mb-2'
                ],
            ])
            ->add('document', FileType::class, [
                'label' => '',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,
                'attr' => [
                    'class' => 'file file-cta'
                ],
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],
            ])
            ->add('full_name', TextType::class, [
                'label' => 'Фамилия Имя Отчество',
                'attr' => [
                    'class' => 'input mb-2',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => "Телефон",
                'attr' => [
                    'class' => 'input mb-2',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('id_room', TextType::class, [
                'label' => "Идентификатор помещения",
                'attr' => [
                    'class' => 'input mb-2',
                    'autofocus' => 'autofocus',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookingRequest::class,
        ]);
    }
}
