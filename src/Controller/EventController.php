<?php

namespace App\Controller;

use DateTime;
use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(): JsonResponse
    {
        //Fais en sorte que ton controller renvoies des données de ta BDD
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EventController.php',
        ]);
    }

    /**
     * Renvoie tous les events
     *
     * @param EventRepository $repository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/events', name: 'event.getAll', methods:['GET'])]
    public function getAllEvents(
        EventRepository $repository,
        SerializerInterface $serializer
        ): JsonResponse
    {
        $events =  $repository->findAll();
        $jsonEvents = $serializer->serialize($events, 'json',["groups" => "getAllEvents"]);
        return new JsonResponse(    
            $jsonEvents,
            Response::HTTP_OK, 
            [], 
            true
        );
    } 

    /*
    #[Route('/api/events/{idEvent}', name:  'event.get', methods: ['GET'])]
    public function getEvent(int $idEvent, SerializerInterface $serializer, EventRepository $repository): JsonResponse {

        $event = $repository->find($idEvent);
        return $event ? 
            new JsonResponse($serializer->serialize($event, 'json'), Response::HTTP_OK, [], true)
            : new JsonResponse(null, Response::HTTP_NOT_FOUND);
   }*/


   /**
    * Renvoie un event par son id
    *
    * @param Event $event
    * @param SerializerInterface $serializer
    * @return JsonResponse
    */
    #[Route('/api/events/{idEvent}', name:  'event.get', methods: ['GET'])]
    #[ParamConverter("event", options: ["id" => "idEvent"])]
    
   public function getEvent(Event $event, SerializerInterface $serializer): JsonResponse 
   {
       $jsonEvent = $serializer->serialize($event, 'json', ["groups" => "getAllEvents"]);
       return new JsonResponse($jsonEvent, Response::HTTP_OK, ['accept' => 'json'], true);
   }


   #[Route('/api/events/{idEvent}', name: 'event.delete', methods: ['DELETE'])]
    #[ParamConverter("event", options: ["id" => "idEvent"])]
   public function deleteEvent(Event $event, EntityManagerInterface $entityManager): JsonResponse 
   {
       $entityManager->remove($event);
       $entityManager->flush();

       return new JsonResponse(null, Response::HTTP_NO_CONTENT);
   }

   #[Route('/api/events', name:"event.create", methods: ['POST'])]
   public function createEvent(Request $request, AuthorRepository $authorRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): JsonResponse 
   {

        $event = $serializer->deserialize($request->getContent(), Event::class, 'json');
        $entityManager->persist($event);
        $entityManager->flush();

        $content = $request->toArray();

        $idAuthor = $content['idAuthor'] ?? -1;

        $event->setAuthor($authorRepository->find($idAuthor));
   
        $jsonBook = $serializer->serialize($event, 'json', ['groups' => 'getAllEvents']);
       
        $location = $urlGenerator->generate('event.get', ['idEvent' => $event->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

         return new JsonResponse($jsonBook, Response::HTTP_CREATED, ["Location" => $location], true);
  }
 
  

    #[Route('/api/events/{id}', name:"event.update", methods:['PUT'])]

    public function updateBook(Request $request, SerializerInterface $serializer, Event $event, EntityManagerInterface $entityManager, AuthorRepository $authorRepository): JsonResponse 
    {
        $updatedEvent = $serializer->deserialize($request->getContent(), 
                Event::class, 
                'json', 
                [AbstractNormalizer::OBJECT_TO_POPULATE => $event]);
        $content = $request->toArray();
        $idAuthor = $content['idAuthor'] ?? -1;
        $updatedEvent->setAuthor($authorRepository->find($idAuthor));
        
        $entityManager->persist($updatedEvent);
        $entityManager->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
   }
   
}
