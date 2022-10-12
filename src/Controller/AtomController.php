<?php

namespace App\Controller;

use App\Repository\AtomRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AtomController extends AbstractController
{
    #[Route('/atom', name: 'app_atom')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AtomController.php',
        ]);
    }

    /**
     * Renvoie tous les auteurs
     *
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/atoms', name: 'atoms.getAll', methods:['GET'])]
    public function getAllAuthors(
        AtomRepository $repository,
        SerializerInterface $serializer
        ): JsonResponse
    {
        $authors =  $repository->findAll();
        $jsonAuthors = $serializer->serialize($authors, 'json',["groups" => "getAllAtoms"]);
        return new JsonResponse(    
            $jsonAuthors,
            Response::HTTP_OK, 
            [], 
            true
        );
    } 

}
