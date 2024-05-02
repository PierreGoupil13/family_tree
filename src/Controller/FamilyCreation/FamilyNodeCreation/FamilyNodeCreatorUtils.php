<?php

namespace App\Controller\FamilyCreation\FamilyNodeCreation;

use App\Entity\FamilyNode;
use App\Repository\FamilyNodeRepository;

class FamilyNodeCreatorUtils
{
    private FamilyNodeRepository $familyNodeRepository;

    public function __construct(FamilyNodeRepository $familyNodeRepository)
    {
        $this->familyNodeRepository = $familyNodeRepository;
    }

    // Une fonction qui permet de trier les données du formulaire de creation d'une famille et de persister celle-ci en base
    public function CreateFamilyNode(String $famillyName)
    {
        $newFamilyNode = new FamilyNode();
        $newFamilyNode->setName($famillyName);

        $result = $this->familyNodeRepository->persist($newFamilyNode);

        return $result;
    }

}