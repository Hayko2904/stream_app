<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addressLine1', TextType::class, [
                'label' => 'Address Line 1',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3']
            ])
            ->add('addressLine2', TextType::class, [
                'label' => 'Address Line 2 (Optional)',
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3']
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3']
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Postal Code',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3']
            ])
            ->add('state', TextType::class, [
                'label' => 'State/Province',
                'attr' => ['class' => 'form-control'],
                'row_attr' => ['class' => 'mb-3']
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'United States' => 'US',
                    'Canada' => 'CA',
                    'United Kingdom' => 'GB',
                    'Australia' => 'AU',
                    'Germany' => 'DE',
                    'France' => 'FR',
                    'Japan' => 'JP',
                    'India' => 'IN'
                ],
                'label' => 'Country',
                'attr' => ['class' => 'form-select'],
                'row_attr' => ['class' => 'mb-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
} 