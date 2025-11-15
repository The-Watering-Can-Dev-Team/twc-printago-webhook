<?php

namespace PrintagoWebhook\src;

use JsonSerializable;

class PrinterMetadata implements JsonSerializable
{
    public function __construct(
        public string $name,
        public string $dev_id,
        public bool $online,
        public string $print_status,
        public string $dev_model_name,
        public string $dev_access_code,
        public float $nozzle_diameter,
        public string $dev_product_name
    ) {}

    public static function fromJson(array $json): self
    {
        return new self(
            name: $json['name'],
            dev_id: $json['dev_id'],
            online: $json['online'],
            print_status: $json['print_status'],
            dev_model_name: $json['dev_model_name'],
            dev_access_code: $json['dev_access_code'],
            nozzle_diameter: $json['nozzle_diameter'],
            dev_product_name: $json['dev_product_name']
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'dev_id' => $this->dev_id,
            'online' => $this->online,
            'print_status' => $this->print_status,
            'dev_model_name' => $this->dev_model_name,
            'dev_access_code' => $this->dev_access_code,
            'nozzle_diameter' => $this->nozzle_diameter,
            'dev_product_name' => $this->dev_product_name
        ];
    }
}