<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\ApiException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if ($e instanceof ApiException) {
            $event->setResponse(
                new JsonResponse(
                    ['error' => $e->getErrorMessage()],
                    $e->getStatusCode()
                )
            );
        } elseif (
            $e instanceof BadRequestHttpException
            && $e->getPrevious() instanceof ValidationFailedException
        ) {
            /** @var ValidationFailedException $validationException */
            $validationException = $e->getPrevious();

            $errors = [];
            foreach ($validationException->getViolations() as $violation) {
                /** @var ConstraintViolationInterface $violation */
                $errors[$violation->getPropertyPath()][] = $violation->getMessage();
            }

            $event->setResponse(
                new JsonResponse(
                    ['errors' => $errors],
                    Response::HTTP_BAD_REQUEST
                )
            );
        } elseif ($e instanceof ExceptionInterface) {
            $event->setResponse(
                new JsonResponse(
                    ['error' => 'invalid_request_format', 'message' => $e->getMessage()],
                    Response::HTTP_BAD_REQUEST
                )
            );
        }else {
            $event->setResponse(
                new JsonResponse(['error' => 'internal_error'], 500)
            );
        }
    }
}
