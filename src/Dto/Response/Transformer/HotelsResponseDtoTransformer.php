<?php
declare(strict_types=1);

namespace App\Dto\Response\Transformer;

use App\Dto\Response\HotelsResponseDto;
use App\Entity\Hotel;

class HotelsResponseDtoTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param Hotel $item
     * @return HotelsResponseDto
     */
    public function transformFromItem($item): HotelsResponseDto
    {
        $dto = new HotelsResponseDto();
        $dto->id = $item->getId();
        $dto->name = $item->getName();

        return $dto;
    }
}