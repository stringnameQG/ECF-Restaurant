<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserInfos;
use App\Service\Mailer;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Common\Collections\Criteria;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/{page<\d+>?1}', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, int $page): Response
    {
        $userPerPage = 20;
        
        $criteria = Criteria::create()
            ->setFirstResult(($page - 1) * $userPerPage)
            ->setMaxResults($userPerPage);

        $user = $userRepository->matching($criteria);

        $totalUser = count($userRepository->matching(Criteria::create()));

        $totalPages = ceil($totalUser / $userPerPage);
        return $this->render('user/index.html.twig', [
            'users' => $user,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher,
        Mailer $mail
    ): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            $emailAdresse = $form->get('email')->getData();
            $password = $form->get('password')->getData();

            $mail->ConfirmInscription($emailAdresse, $password);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/MonCompte', name: 'app_user_mon_compte', methods: ['GET', 'POST'])]
    public function MonCompte(
        Request $request, 
        EntityManagerInterface $entityManager,
    ): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserInfos::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('current_user/current_user.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        User $user, 
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher,
        Mailer $mail
    ): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            $emailAdresse = $form->get('email')->getData();
            $password = $form->get('password')->getData();

            $mail->ConfirmInscription($emailAdresse, $password);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}

