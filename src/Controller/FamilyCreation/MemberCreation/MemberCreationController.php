<?php

namespace App\Controller\FamilyCreation\MemberCreation;

use App\Form\FamilyCreation\MemberType;
use App\Repository\FamilyNodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MemberCreationController extends AbstractController
{
    #[Route('/member/add', name: 'member_creation')]
    public function newMember(Request $request): Response
    {
        // Create form
        $form = $this->createForm(MemberType::class);

        // See if form filled, if not render the form, else work with the data
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newMember = $form->getData();

            return $this->redirectToRoute('member_created');
        }

        return $this->render('family_member_management/family_creation_form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/member/success', name: 'member_created')]
    public function memberCreated(Request $request): Response
    {


        return $this->render('family_member_management/family_creation_success_form.html.twig');
    }

    #[Route('/family/get', name: 'app_family_member_get')]
    public function getMember(Request $request, FamilyNodeRepository $familyRepository): Response
    {
        $familly = $familyRepository->findAll()[0];
        $child = $familly->getChildren()[0];
        $parents = $familly->getParents()[0];

        return $this->render('family_member_management/form.html.twig', [
            'form' => $form,
        ]);
    }
}