<?php

namespace App\Controller;

use App\Service\SseService;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SseController extends AbstractController
{
    private SseService $sseService;

    public function __construct(SseService $sseService)
    {
        $this->sseService = $sseService;
    }

    #[Route('/sse/updates', name: 'sse_updates')]
    public function streamUpdates(): StreamedResponse
    {
        return new StreamedResponse(function () {
            while (true) {
                $messages = $this->sseService->getMessages();

                foreach ($messages as $msg) {
                    echo "data: " . json_encode($msg) . "\n\n";
                    ob_flush();
                    flush();
                }

                sleep(1);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive'
        ]);
    }
}
