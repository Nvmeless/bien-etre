<?php

namespace App\Controller;

use DateTime;
use App\Entity\Event;
use DateTimeImmutable;
use JMS\Serializer\Serializer;
use App\Repository\EventRepository;
use App\Repository\AuthorRepository;
use JMS\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;

use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    public function getAllEventsUnderDays(
        EventRepository $repository,
        SerializerInterface $serializer,
        Request $request
        ): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 5);
        $datetime = new DateTimeImmutable();
        
        $context = SerializationContext::create()->setGroups(['getAllEvents']);
        $events =  $repository->findEventBetween($datetime->modify('+31 day'), $datetime, $page, $limit);
        $jsonEvents = $serializer->serialize($events, 'json',$context);
        return new JsonResponse(    
            $jsonEvents,
            Response::HTTP_OK, 
            [], 
            true
        );
    } 


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
    
        $context = SerializationContext::create()->setGroups(['getAllEvents']);
        $jsonEvent = $serializer->serialize($event, 'json',$context);
        return new JsonResponse($jsonEvent, Response::HTTP_OK, ['accept' => 'json'], true);
   }


   #[Route('/api/events', name:"event.create", methods: ['POST'])]
   #[IsGranted('ADMIN', message: 'Hanhanhan, vous n\avez pas dit le mot magiquenh')]
   public function createEvent(Request $request, AuthorRepository $authorRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): JsonResponse 
   {

        $event = $serializer->deserialize($request->getContent(), Event::class, 'json');
        $entityManager->persist($event);
        $entityManager->flush();

        $content = $request->toArray();

        $idAuthor = $content['idAuthor'] ?? -1;

        $event->setAuthor($authorRepository->find($idAuthor));
        $context = SerializationContext::create()->setGroups(['getAllEvents']);
        $jsonBook = $serializer->serialize($event, 'json', $context );
       
        $location = $urlGenerator->generate('event.get', ['idEvent' => $event->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

         return new JsonResponse($jsonBook, Response::HTTP_CREATED, ["Location" => $location], true);
  }
 
  

    #[Route('/api/events/{id}', name:"event.update", methods:['PUT'])]
    public function updateEvent(Request $request, SerializerInterface $serializer, Event $event, EntityManagerInterface $entityManager, AuthorRepository $authorRepository, TagAwareCacheInterface $cache): JsonResponse 
    {
        $updatedEvent = $serializer->deserialize($request->getContent(), 
                Event::class, 
                'json');

        
        $event->setEventName($updatedEvent->getEventName() ?? $event->getEventName());
        $event->setEventPrice($updatedEvent->getEventPrice() ?? $event->getEventPrice());
        $event->setEventDesc($updatedEvent->getEventDesc() ?? $event->getEventDesc());
        $event->setEventStartDate($updatedEvent->getEventStartDate() ?? $event->getEventStartDate());
        $event->setEventEndDate($updatedEvent->getEventEndDate() ?? $event->setEventEndDate());
        
        $content = $request->toArray();
        $idAuthor = $content['idAuthor'] ?? -1;
        $event->setAuthor($authorRepository->find($idAuthor));
        $cache->invalidateTags(["atomsCache"]);
        $entityManager->persist($event);
        $entityManager->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
   }
   


   



}
