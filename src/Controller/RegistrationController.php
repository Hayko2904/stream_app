<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Payment;
use App\Form\UserInformationType;
use App\Form\AddressInformationType;
use App\Form\PaymentInformationType;
use App\Repository\UserRepository;
use App\Repository\AddressRepository;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/register')]
class RegistrationController extends AbstractController
{
    #[Route('/', name: 'app_register_step1', methods: ['GET', 'POST'])]
    public function step1(
        Request $request,
        SessionInterface $session,
        ValidatorInterface $validator
    ): Response {
        $user = $session->get('registration_user', new User());
        $form = $this->createForm(UserInformationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($user);
            if (count($errors) === 0) {
                $session->set('registration_user', $user);
                return $this->redirectToRoute('app_register_step2');
            }
        }

        return $this->render('registration/step1.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/address', name: 'app_register_step2', methods: ['GET', 'POST'])]
    public function step2(
        Request $request,
        SessionInterface $session,
        ValidatorInterface $validator
    ): Response {
        $user = $session->get('registration_user');
        if (!$user) {
            return $this->redirectToRoute('app_register_step1');
        }

        $address = $user->getAddress() ?? new Address();
        $form = $this->createForm(AddressInformationType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($address);
            if (count($errors) === 0) {
                $user->setAddress($address);
                $session->set('registration_user', $user);
                
                if ($user->getSubscriptionType() === 'premium') {
                    return $this->redirectToRoute('app_register_step3');
                }
                
                return $this->redirectToRoute('app_register_confirmation');
            }
        }

        return $this->render('registration/step2.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/payment', name: 'app_register_step3', methods: ['GET', 'POST'])]
    public function step3(
        Request $request,
        SessionInterface $session,
        ValidatorInterface $validator
    ): Response {
        $user = $session->get('registration_user');
        if (!$user || $user->getSubscriptionType() !== 'premium') {
            return $this->redirectToRoute('app_register_step1');
        }

        $payment = $user->getPayment() ?? new Payment();
        $form = $this->createForm(PaymentInformationType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($payment, null, ['payment']);
            if (count($errors) === 0) {
                $user->setPayment($payment);
                $session->set('registration_user', $user);
                return $this->redirectToRoute('app_register_confirmation');
            }
        }

        return $this->render('registration/step3.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/confirmation', name: 'app_register_confirmation', methods: ['GET', 'POST'])]
    public function confirmation(
        Request $request,
        SessionInterface $session,
        UserRepository $userRepository,
        AddressRepository $addressRepository,
        PaymentRepository $paymentRepository
    ): Response {
        $user = $session->get('registration_user');
        if (!$user) {
            return $this->redirectToRoute('app_register_step1');
        }

        if ($request->isMethod('POST')) {
            $userRepository->save($user, true);
            $session->remove('registration_user');
            return $this->redirectToRoute('app_register_success');
        }

        return $this->render('registration/confirmation.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/success', name: 'app_register_success', methods: ['GET'])]
    public function success(): Response
    {
        return $this->render('registration/success.html.twig');
    }
} 