<?php

namespace PrintagoWebhook\src;

use JsonSerializable;

class MaterialMapping implements JsonSerializable
{
    public function __construct(
        public ?string $name = null,
        public ?int $slot = null,
        public ?string $variantId = null,
        public ?string $filamentUserProfileId = null,
        public ?bool $skip = null
    ) {}

    public static function fromJson(array $json): self
    {
        return new self(
            name: $json['name'] ?? null,
            slot: $json['slot'] ?? null,
            variantId: $json['variantId'] ?? null,
            filamentUserProfileId: $json['filamentUserProfileId'] ?? null,
            skip: $json['skip'] ?? null
        );
    }

    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->skip !== null) {
            $data['skip'] = $this->skip;
            $data['slot'] = $this->slot;
        } else {
            if ($this->name !== null) $data['name'] = $this->name;
            if ($this->slot !== null) $data['slot'] = $this->slot;
            if ($this->variantId !== null) $data['variantId'] = $this->variantId;
            if ($this->filamentUserProfileId !== null) $data['filamentUserProfileId'] = $this->filamentUserProfileId;
        }

        return $data;
    }
}