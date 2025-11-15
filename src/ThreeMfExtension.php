<?php

namespace PrintagoWebhook\src;

use JsonSerializable;

class ThreeMfExtension implements JsonSerializable
{
    public function __construct(
        public int $plateId,
        public string $gcodeFile
    ) {}

    public static function fromJson(array $json): self
    {
        return new self(
            plateId: $json['plateId'],
            gcodeFile: $json['gcodeFile']
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'plateId' => $this->plateId,
            'gcodeFile' => $this->gcodeFile
        ];
    }
}