<?php
declare(strict_types=1);

namespace App\Dto\Response\Transformer;

use App\Dto\Response\AnalyticsResponseDto;
use App\Repository\ReviewRepository;
use DateTime;

class AnalyticsResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param array $item
     * @return AnalyticsResponseDto
     */
    public function transformFromItem($item): AnalyticsResponseDto
    {
        $dto = new AnalyticsResponseDto();
        $dto->datePoint = $this->getDatePoint($item['date_point'], $item['mode']);
        $dto->count = (int)$item['review_count'];
        $dto->average = (float)$item['average_score'];

        return $dto;
    }

    private function getDatePoint(string $datePoint, string $mode): string
    {
        switch ($mode) {
            case ReviewRepository::DAILY:
                return $datePoint;
            case ReviewRepository::WEEKLY:
                $weekNumber = substr($datePoint, 4);
                $year = substr($datePoint, 0, 4);
                return "$year week no. $weekNumber";
            case ReviewRepository::MONTHLY:
            default:
                $date = new DateTime($datePoint);
                return $date->format('Y F');
        }
    }
}