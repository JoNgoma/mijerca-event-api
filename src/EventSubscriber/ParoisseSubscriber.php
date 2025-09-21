<?php

namespace App\EventSubscriber;

use App\Entity\Paroisse;
use App\Service\SseService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class ParoisseSubscriber implements EventSubscriber
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

        if (!$entity instanceof Paroisse) return;

        $this->sseService->pushMessage([
            'type' => 'paroisse',
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'doyenne' => $entity->getDoyenne()?->getId(),
            'sector' => $entity->getSector()?->getId()
        ]);
    }
}

