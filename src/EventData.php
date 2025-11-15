<?php

namespace PrintagoWebhook\src;

use JsonSerializable;

class EventData implements JsonSerializable
{
    public function __construct(
        public Printer $printer,
        public ?PrintJob $printJob = null
    ) {}

    public static function fromJson(array $json): self
    {
        return new self(
            printer: Printer::fromJson($json['printer']),
            printJob: isset($json['printJob']) ? PrintJob::fromJson($json['printJob']) : null
        );
    }

    public function jsonSerialize(): array
    {
        $data = ['printer' => $this->printer];

        if ($this->printJob !== null) {
            $data['printJob'] = $this->printJob;
        }

        return $data;
    }
}