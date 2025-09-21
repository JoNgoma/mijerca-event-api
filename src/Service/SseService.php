<?php

namespace App\Service;

class SseService
{
    private array $messages = [];

    public function pushMessage(array $message): void
    {
        $this->messages[] = $message;

        // Limiter la mémoire pour éviter une surcharge
        if (count($this->messages) > 100) {
            array_shift($this->messages);
        }
    }

    public function getMessages(): array
    {
        // Retourne et vide la liste pour ne pas renvoyer plusieurs fois
        $msgs = $this->messages;
        $this->messages = [];
        return $msgs;
    }
}
