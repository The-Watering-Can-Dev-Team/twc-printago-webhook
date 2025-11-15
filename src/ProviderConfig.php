<?php

namespace PrintagoWebhook\src;

use JsonSerializable;

class ProviderConfig implements JsonSerializable
{
    public function __construct(
        public bool $use_ams,
        public string $bed_type,
        public ?bool $do_flow_cali = null,
        public bool $do_bed_leveling = true
    ) {}

    public static function fromJson(array $json): self
    {
        return new self(
            use_ams: $json['use_ams'],
            bed_type: $json['bed_type'],
            do_flow_cali: $json['do_flow_cali'] ?? null,
            do_bed_leveling: $json['do_bed_leveling'] ?? true
        );
    }

    public function jsonSerialize(): array
    {
        $data = [
            'use_ams' => $this->use_ams,
            'bed_type' => $this->bed_type,
            'do_bed_leveling' => $this->do_bed_leveling
        ];

        if ($this->do_flow_cali !== null) {
            $data['do_flow_cali'] = $this->do_flow_cali;
        }

        return $data;
    }
}