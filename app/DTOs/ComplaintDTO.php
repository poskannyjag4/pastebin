<?php

namespace App\DTOs;

class ComplaintDTO
{
    /**
     * @param string $details
     */
    public function __construct(
        public string $details,
    )
    {
    }

    /**
     * @param array{
     *     details: string
     * } $data
     * @return ComplaintDTO
     */
    public static function fromArray(array $data): ComplaintDTO{
        return new ComplaintDTO(
            details: $data['details'],
        );
    }
}
