<?php
declare(strict_types=1);

namespace App\Dto\Response\Transformer;

use App\Dto\Response\AnalyticsResponseDto;

class AnalyticsResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param array $item
     * @return AnalyticsResponseDto
     */
    public function transformFromItem($item): AnalyticsResponseDto
    {
        $dto = new AnalyticsResponseDto();
        $dto->datePoint = $item['date_point'];
        $dto->count = (int)$item['review_count'];
        $dto->average = (float)$item['average_score'];

        return $dto;
    }
}