<?php

namespace App\Form;

use App\Entity\BookingRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
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
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'class' => 'input mb-2',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Описание',
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'class' => 'input mb-2',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('date_start', DateTimeType::class, [
                'label' => 'Начало',
                'label_attr' => [
                    'class' => 'label'
                ],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input',
                    'format' => 'yyyy-MM-dd',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('date_finish', DateTimeType::class, [
                'label' => 'Окончание',
                'label_attr' => [
                    'class' => 'label'
                ],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input',
                    'format' => 'yyyy-MM-dd',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('document', FileType::class, [
                'label' => 'Документ',
                'label_attr' => [
                    'class' => 'label'
                ],

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
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'class' => 'input mb-2',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => "Телефон",
                'label_attr' => [
                    'class' => 'label'
                ],
                'attr' => [
                    'class' => 'input mb-2',
                    'autofocus' => 'autofocus',
                ],
            ])
            ->add('id_room', TextType::class, [
                'label' => "Идентификатор помещения",
                'label_attr' => [
                    'class' => 'label'
                ],
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
