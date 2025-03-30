<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('creditCardNumber', TextType::class, [
                'label' => 'Credit Card Number',
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '19',
                    'pattern' => '[0-9\s]{19}',
                    'placeholder' => '4111 1111 1111 1111'
                ],
                'row_attr' => ['class' => 'mb-3']
            ])
            ->add('cardExpiration', TextType::class, [
                'label' => 'Expiration Date (MM/YY)',
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '5',
                    'pattern' => '(0[1-9]|1[0-2])/([0-9]{2})',
                    'placeholder' => 'MM/YY'
                ],
                'row_attr' => ['class' => 'mb-3']
            ])
            ->add('cvv', TextType::class, [
                'label' => 'CVV',
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => '3',
                    'pattern' => '[0-9]{3}'
                ],
                'row_attr' => ['class' => 'mb-3']
            ])
            ->add('cardHolderName', TextType::class, [
                'label' => 'Card Holder Name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Name as it appears on card'
                ],
                'row_attr' => ['class' => 'mb-3']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Next Step',
                'attr' => ['class' => 'btn btn-primary']
            ]);

        // Add event listeners for formatting
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            
            // Format credit card number
            if (isset($data['creditCardNumber'])) {
                // Remove all spaces and validate length
                $cardNumber = preg_replace('/\s+/', '', $data['creditCardNumber']);
                if (strlen($cardNumber) !== 16) {
                    $event->getForm()->addError(new \Symfony\Component\Form\FormError('Credit card number must be 16 digits'));
                    return;
                }
                $data['creditCardNumber'] = $cardNumber;
            }
            
            $event->setData($data);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
            'validation_groups' => ['payment']
        ]);
    }
} 