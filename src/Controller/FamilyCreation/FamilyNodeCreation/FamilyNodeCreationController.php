<?php

namespace App\Controller\FamilyCreation\FamilyNodeCreation;

use App\Form\FamilyCreation\FamilyNodeType;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class FamilyNodeCreationController extends AbstractController
{

    private FamilyNodeCreatorUtils $creatorUtils;

    public function __construct(FamilyNodeCreatorUtils $creatorUtils)
    {
        $this->creatorUtils = $creatorUtils;
    }
    #[Route('family/node/create', name: 'family_node_creation')]
    public function createFamilyNode(Request $request): Response
    {
        // Create form
        $form = $this->createForm(FamilyNodeType::class);

        // See if form filled, if not render the form, else work with the data
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Get family node name
            $newFamilyNodeName = $form->getData();
            $newFamilyNode = $this->creatorUtils->CreateFamilyNode($newFamilyNodeName['name']);
            // Create and persist family node

            return $this->redirectToRoute('family_node_created');
        }

        return $this->render('family_member_management/family_node/family_creation_form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('family/node/success', name: 'family_node_created')]
    public function successCreationFamilyNode()
    {
        return $this->render('family_member_management/family_node/family_node_creation_success_form.html.twig');
    }
}
