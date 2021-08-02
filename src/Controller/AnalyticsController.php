<?php

namespace App\Controller;

use App\Dto\Response\Transformer\AnalyticsResponseDtoTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReviewRepository;
use Throwable;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnalyticsController extends AbstractController
{
    private ValidatorInterface $validator;
    private AnalyticsResponseDtoTransformer $analyticsResponseDtoTransformer;

    public function __construct(AnalyticsResponseDtoTransformer $analyticsResponseDtoTransformer, ValidatorInterface $validator)
    {
        $this->analyticsResponseDtoTransformer = $analyticsResponseDtoTransformer;
        $this->validator = $validator;
    }

    #[Route('/api/analytics', name: 'api.analytics')]
    /**
     * @param Request $request
     * @param ReviewRepository $reviewRepository
     * @return JsonResponse
     * @throws Throwable
     */
    public function index(Request $request, ReviewRepository $reviewRepository): JsonResponse
    {
        $errors = $this->validate($request);

        if (count($errors)) {
            $errorsString = (string) $errors;
            return new JsonResponse(['message' => $errorsString], 409);
        }

        $hotelId = $request->query->get('hotel_id');
        $fromDate = new DateTime($request->query->get('from'));
        $toDate = new DateTime($request->query->get('to'));

        $mode = $this->getMode($fromDate, $toDate);
        $resultItems = $reviewRepository->analysis($hotelId, $fromDate, $toDate, $mode);

        $dto = $this->analyticsResponseDtoTransformer->transformFromArrayItems($resultItems);

        return new JsonResponse($dto);
    }

    private function validate(Request $request)
    {
        $data = $request->query->all();

        $hotelIdConditions = [
            new Assert\NotBlank(),
            new Assert\Positive(),
        ];
        $fromConditions = [
            new Assert\NotBlank(),
            new Assert\Date(),
        ];
        $toConditions = [
            new Assert\NotBlank(),
            new Assert\Date(),
        ];

        if ($request->query->has('from')) {
            $toConditions = array_merge(
                $toConditions,
                [
                    new Assert\GreaterThanOrEqual($request->query->get('from'))
                ]
            );
        }

        $constraints = new Assert\Collection([
            'hotel_id' => $hotelIdConditions,
            'from' => $fromConditions,
            'to' => $toConditions
        ]);

        return $this->validator->validate($data, $constraints);
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
