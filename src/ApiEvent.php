<?php

namespace PrintagoWebhook\src;

use DateTime;
use JsonSerializable;

class ApiEvent implements JsonSerializable
{
    public function __construct(
        public string $event,
        public DateTime $timestamp,
        public EventData $data
    ) {}

    public static function fromJson(array $json): self
    {
        return new self(
            event: $json['event'],
            timestamp: new DateTime($json['timestamp']),
            data: EventData::fromJson($json['data'])
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'event' => $this->event,
            'timestamp' => $this->timestamp->format('c'),
            'data' => $this->data
        ];
    }
}