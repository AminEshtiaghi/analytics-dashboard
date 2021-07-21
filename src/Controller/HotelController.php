<?php

namespace App\Controller;

use App\Dto\Response\Transformer\HotelsResponseDtoTransformer;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    private HotelsResponseDtoTransformer $hotelsResponseDtoTransformer;

    public function __construct(HotelsResponseDtoTransformer $hotelsResponseDtoTransformer)
    {
        $this->hotelsResponseDtoTransformer = $hotelsResponseDtoTransformer;
    }

    /**
     * @Route("/api/hotel/all", name="api.hotel.all")
     * @param HotelRepository $hotelRepository
     * @return JsonResponse
     */
    public function getAll(HotelRepository $hotelRepository): JsonResponse
    {
        $resultItems = $hotelRepository->findAll();

        $dto = $this->hotelsResponseDtoTransformer->transformFromArrayItems($resultItems);

        return new JsonResponse($dto);
    }
}
