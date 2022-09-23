<?php

namespace App\Controller;

use DateTime;
use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\SerializerInterface;
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
        $jsonEvents = $serializer->serialize($events, 'json');
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
       $jsonEvent = $serializer->serialize($event, 'json');
       return new JsonResponse($jsonEvent, Response::HTTP_OK, ['accept' => 'json'], true);
   }
}
