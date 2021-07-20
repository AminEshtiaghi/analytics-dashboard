<?php
declare(strict_types=1);

namespace App\Dto\Response;

use JMS\Serializer\Annotation as Serialization;

class AnalyticsResponseDto
{
    /**
     * @Serialization\Type("string")
     */
    public string $datePoint;

    /**
     * @Serialization\Type("int")
     */
    public int $count;

    /**
     * @Serialization\Type("float")
     */
    public float $average;
}