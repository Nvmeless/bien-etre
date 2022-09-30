<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\EventRepository;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthorController.php',
        ]);
    }

    /**
     * Renvoie tous les auteurs
     *
     * @param AuthorRepository $repository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/authors', name: 'author.getAll', methods:['GET'])]
    public function getAllAuthors(
        AuthorRepository $repository,
        SerializerInterface $serializer
        ): JsonResponse
    {
        $authors =  $repository->findAll();
        $jsonAuthors = $serializer->serialize($authors, 'json',["groups" => "getAllAuthors"]);
        return new JsonResponse(    
            $jsonAuthors,
            Response::HTTP_OK, 
            [], 
            true
        );
    } 


   /**
    * Renvoie un author par son id
    *
    * @param Author $author
    * @param SerializerInterface $serializer
    * @return JsonResponse
    */
    #[Route('/api/authors/{idAuthor}', name:  'author.get', methods: ['GET'])]
    #[ParamConverter("author", options: ["id" => "idAuthor"])]
    
   public function getAuthor(Author $author, SerializerInterface $serializer): JsonResponse 
   {
       $jsonAuthors = $serializer->serialize($author, 'json', ["groups" => "getAllAuthors"]);
       return new JsonResponse($jsonAuthors, Response::HTTP_OK, ['accept' => 'json'], true);
   }


   #[Route('/api/authors/{idAuthor}', name: 'author.delete', methods: ['DELETE'])]
    #[ParamConverter("author", options: ["id" => "idAuthor"])]
   public function deleteAuthor(Author $author, EntityManagerInterface $entityManager): JsonResponse 
   {
       $entityManager->remove($author);
       $entityManager->flush();

       return new JsonResponse(null, Response::HTTP_NO_CONTENT);
   }

   #[Route('/api/authors', name:"author.create", methods: ['POST'])]
   public function createAuthor(Request $request, EventRepository $eventRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, ValidatorInterface $validator): JsonResponse 
   {

        $author = $serializer->deserialize($request->getContent(), Author::class, 'json');
       
        $errors = $validator->validate($author);
        if($errors->count() > 0){
            return new JsonResponse($serializer->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [],true);
        }

        $entityManager->persist($author);
        $entityManager->flush();

        $content = $request->toArray();

        if(array_key_exists('idEvent',$content) && $content['idEvent']){
        //Comment mettre plusieurs event d'un coup ?
        $author->addEvent($eventRepository->find( $content['idEvent']));
        $entityManager->persist($author);
        $entityManager->flush();
        }

        $jsonBook = $serializer->serialize($author, 'json', ['groups' => 'getAllAuthors']);
       
        $location = $urlGenerator->generate('author.get', ['idAuthor' => $author->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

         return new JsonResponse($jsonBook, Response::HTTP_CREATED, ["Location" => $location], true);
  }
 
  

    #[Route('/api/authors/{id}', name:"author.update", methods:['PUT'])]

    public function updateBook(Request $request, SerializerInterface $serializer, Author $author, EntityManagerInterface $entityManager, EventRepository $eventRepository): JsonResponse 
    {
        $updatedAuthor = $serializer->deserialize($request->getContent(), 
                Author::class, 
                'json', 
                [AbstractNormalizer::OBJECT_TO_POPULATE => $author]);
        $content = $request->toArray();

        if(array_key_exists('idEvent',$content) && $content['idEvent']){
            //Comment mettre plusieurs event d'un coup ?
            $updatedAuthor->addEvent($eventRepository->find( $content['idEvent']));
            $entityManager->persist($updatedAuthor);
            $entityManager->flush();
        }
        
        $entityManager->persist($updatedAuthor);
        $entityManager->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
   }
}
