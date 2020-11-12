<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ExceptionSubscriber
 * @package App\EventSubscriber
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::EXCEPTION => [
                ['processException', 10],
                ['logException', 0],
                ['notifyException', -10],
            ],
        ];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function processException(ExceptionEvent $event)
    {
        echo json_encode([
            'title' => 'Not Found',
            'status' => 404,
            'message' => 'Unable to find requested resource.'
        ]);
        die;
    }
}