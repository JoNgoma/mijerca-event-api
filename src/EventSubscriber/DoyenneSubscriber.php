<?php
namespace App\EventSubscriber;

use App\Entity\Doyenne;
use App\Service\SseService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class DoyenneSubscriber implements EventSubscriber
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

        if (!$entity instanceof Doyenne) return;

        $this->sseService->pushMessage([
            'type' => 'doyenne',
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'sector' => $entity->getSector()?->getId()
        ]);
    }
}
