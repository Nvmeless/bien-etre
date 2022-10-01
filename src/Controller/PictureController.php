<?php

namespace App\Controller;

use DateTime;
use App\Entity\Picture;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PictureController extends AbstractController
{
    #[Route('/', name: 'app_picture')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PictureController.php',
        ]);
    }

    
    #[Route('/api/pictures/{idPicture}', name:  'picture.get', methods: ['GET'])]
    public function getEvent(int $idPicture, SerializerInterface $serializer, PictureRepository $repository, UrlGeneratorInterface $urlGenerator): JsonResponse {

        $picture = $repository->find($idPicture);

        $location = $picture->getPublicPath() . '/' . $picture->getRealpath();
        $location = $urlGenerator->generate('app_picture', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $location = $location . str_replace('/public/',"",$picture->getPublicPath()) . '/' . $picture->getRealpath();

        return $picture ? 
            new JsonResponse($serializer->serialize($picture, 'json', ['groups' => 'getPictures']), Response::HTTP_OK, ["Location" => $location], true)
            : new JsonResponse(null, Response::HTTP_NOT_FOUND);
   }

    #[Route('/api/pictures', name:"picture.create", methods: ['POST'])]
    /**
     * Undocumented function
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $entityManager
     * @param UrlGeneratorInterface $urlGenerator
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function createPicture(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, ValidatorInterface $validator): JsonResponse 
    {
        $picture = new Picture;
        $files = $request->files->get('file');
        $picture->setFile($files);
        $picture->setMime($files->getClientMimeType());
        $picture->setRealname($files->getClientOriginalName());
        $picture->setPublicPath('/public/images/pictures');
        $picture->setUploadDate(new DateTime());
        $entityManager->persist($picture);
        $entityManager->flush();
        $jsonPicture = $serializer->serialize($picture, 'json', ['groups' => 'getPictures']);


         $location = $urlGenerator->generate('picture.get', ['idPicture' => $picture->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
          return new JsonResponse($jsonPicture, Response::HTTP_CREATED, ["Location" => $location], true);
   }
}
