<?php

namespace App\Controller;

use App\Dto\Response\Transformer\AnalyticsResponseDtoTransformer;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateTime;

class AnalyticsController extends AbstractController
{
    private AnalyticsResponseDtoTransformer $analyticsResponseDtoTransformer;

    public function __construct(AnalyticsResponseDtoTransformer $analyticsResponseDtoTransformer)
    {
        $this->analyticsResponseDtoTransformer = $analyticsResponseDtoTransformer;
    }

    #[Route('/api/analytics', name: 'api.analytics')]
    public function index(ReviewRepository $repository): JsonResponse
    {
        $request = Request::createFromGlobals();
        $hotelId = $request->query->get('hotel_id');
        $fromDate = new DateTime($request->query->get('from'));
        $toDate = new DateTime($request->query->get('to'));

        $mode = $this->getMode($fromDate, $toDate);
        $resultItems = $repository->analysis($hotelId, $fromDate, $toDate, $mode);

        $dto = $this->analyticsResponseDtoTransformer->transformFromArrayItems($resultItems);

        return new JsonResponse($dto);
    }

    private function getMode(DateTime $from, DateTime $to): string
    {
        $diffDays = $to->diff($from)->days;

        if ($diffDays <= 29) {
            return ReviewRepository::DAILY;
        } elseif ($diffDays <= 89) {
            return ReviewRepository::WEEKLY;
        }

        return ReviewRepository::MONTHLY;
    }
}
