<?php

namespace PrintagoWebhook\src;

use JsonSerializable;

class PrintJobExtensions implements JsonSerializable
{
    public function __construct(
        public ThreeMfExtension $threeMf
    ) {}

    public static function fromJson(array $json): self
    {
        return new self(
            threeMf: ThreeMfExtension::fromJson($json['3mf'])
        );
    }

    public function jsonSerialize(): array
    {
        return [
            '3mf' => $this->threeMf
        ];
    }
}