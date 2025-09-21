<?php

namespace App\EventSubscriber;

use App\Entity\Person;
use App\Service\SseService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class PersonSubscriber implements EventSubscriber
{
    private SseService $sseService;

    public function __construct(SseService $sseService)
    {
        $this->sseService = $sseService;
    }

    public function getSubscribedEvents(): array
    {
        return [Events::postPersist];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Person) return;

        // On envoie toutes les données importantes à SSE
        $this->sseService->pushMessage([
            'type'        => 'person',
            'id'          => $entity->getId(),
            'fullName'    => $entity->getFullName(),
            'phoneNumber' => $entity->getPhoneNumber(),
            'gender'      => $entity->getGender(),
            'isNoyau'     => $entity->isNoyau(),
            'isDecanal'   => $entity->isDecanal(),
            'isDicoces'   => $entity->isDicoces(),
            'doyenne'     => $entity->getDoyenne()?->getId() ?? null, // ou ->getUrl() si tu veux l'URL
            'paroisse'    => $entity->getParoisse()?->getId() ?? null,
            'sector'      => $entity->getSector()?->getId() ?? null,
            'createdAt'   => $entity->getCreatedAt()->format('c'),
            'updatedAt'   => $entity->getUpdatedAt()?->format('c') ?? null,
        ]);
    }
}
