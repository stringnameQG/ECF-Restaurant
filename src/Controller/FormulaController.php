<?php

namespace App\Controller;

use App\Entity\Formula;
use App\Form\FormulaType;
use App\Repository\FormulaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/formula')]
class FormulaController extends AbstractController
{
    #[Route('/', name: 'app_formula_index', methods: ['GET'])]
    public function index(FormulaRepository $formulaRepository): Response
    {
        return $this->render('formula/index.html.twig', [
            'formulas' => $formulaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_formula_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formula = new Formula();
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($formula);
            $entityManager->flush();

            return $this->redirectToRoute('app_formula_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formula/new.html.twig', [
            'formula' => $formula,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formula_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formula $formula, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_formula_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formula/edit.html.twig', [
            'formula' => $formula,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formula_delete', methods: ['POST'])]
    public function delete(Request $request, Formula $formula, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formula->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($formula);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formula_index', [], Response::HTTP_SEE_OTHER);
    }
}
