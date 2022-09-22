<?php

namespace App\Controller;

use App\Repository\EventRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
    /*
    #[Route('/api/events', name: 'event.getAll', methods:['GET'])]
    public function getAllEvents(
        EventRepository $repository,
        ): JsonResponse
    {
        $events =  $repository->findAll();

        return new JsonResponse(    
            $events,
            Response::HTTP_OK, 
            [], 
        );
    }
    */

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
    
    #[Route('/api/events/{idEvent}', name: 'event.get', methods:['GET'])]
    public function getEvent(
        int $idEvent,
        EventRepository $repository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        return new JsonResponse(
            ['message' => 'l\'id est : ' . $idEvent],
        );
    }
}
