<?php

namespace PrintagoWebhook\src;

use DateTime;
use JsonSerializable;

class Printer implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $provider,
        public string $deviceId,
        public ProviderConfig $providerConfig,
        public ?string $machineUserProfileId,
        public ?string $machineSystemProfileId,
        public ?string $machineProfileId,
        public ?string $filamentUserProfileId,
        public ?string $filamentSystemProfileId,
        public ?string $filamentProfileId,
        public ?string $processProfileId,
        public ?string $processUserProfileId,
        public ?string $processSystemProfileId,
        public string $name,
        public string $nozzleDiameter,
        public PrinterMetadata $metadata,
        public bool $enabled,
        public ?string $proxyClientId,
        public string $commMethod,
        public array $tags,
        public bool $confirmedReady,
        public bool $isAvailable,
        public bool $isOnline,
        public ?string $printingJobId,
        public ?DateTime $lastPrintedAt,
        public string $integrationId,
        public string $integrationType,
        public bool $continuousPrint,
        public ?int $fabmaticRemainingJobs,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public string $storeId
    ) {}

    public static function fromJson(array $json): self
    {
        return new self(
            id: $json['id'],
            provider: $json['provider'],
            deviceId: $json['deviceId'],
            providerConfig: ProviderConfig::fromJson($json['providerConfig']),
            machineUserProfileId: $json['machineUserProfileId'] ?? null,
            machineSystemProfileId: $json['machineSystemProfileId'] ?? null,
            machineProfileId: $json['machineProfileId'] ?? null,
            filamentUserProfileId: $json['filamentUserProfileId'] ?? null,
            filamentSystemProfileId: $json['filamentSystemProfileId'] ?? null,
            filamentProfileId: $json['filamentProfileId'] ?? null,
            processProfileId: $json['processProfileId'] ?? null,
            processUserProfileId: $json['processUserProfileId'] ?? null,
            processSystemProfileId: $json['processSystemProfileId'] ?? null,
            name: $json['name'],
            nozzleDiameter: $json['nozzleDiameter'],
            metadata: PrinterMetadata::fromJson($json['metadata']),
            enabled: $json['enabled'],
            proxyClientId: $json['proxyClientId'] ?? null,
            commMethod: $json['commMethod'],
            tags: $json['tags'] ?? [],
            confirmedReady: $json['confirmedReady'],
            isAvailable: $json['isAvailable'],
            isOnline: $json['isOnline'],
            printingJobId: $json['printingJobId'] ?? null,
            lastPrintedAt: isset($json['lastPrintedAt']) ? new DateTime($json['lastPrintedAt']) : null,
            integrationId: $json['integrationId'],
            integrationType: $json['integrationType'],
            continuousPrint: $json['continuousPrint'],
            fabmaticRemainingJobs: $json['fabmaticRemainingJobs'] ?? null,
            createdAt: new DateTime($json['createdAt']),
            updatedAt: new DateTime($json['updatedAt']),
            storeId: $json['storeId']
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'provider' => $this->provider,
            'deviceId' => $this->deviceId,
            'providerConfig' => $this->providerConfig,
            'machineUserProfileId' => $this->machineUserProfileId,
            'machineSystemProfileId' => $this->machineSystemProfileId,
            'machineProfileId' => $this->machineProfileId,
            'filamentUserProfileId' => $this->filamentUserProfileId,
            'filamentSystemProfileId' => $this->filamentSystemProfileId,
            'filamentProfileId' => $this->filamentProfileId,
            'processProfileId' => $this->processProfileId,
            'processUserProfileId' => $this->processUserProfileId,
            'processSystemProfileId' => $this->processSystemProfileId,
            'name' => $this->name,
            'nozzleDiameter' => $this->nozzleDiameter,
            'metadata' => $this->metadata,
            'enabled' => $this->enabled,
            'proxyClientId' => $this->proxyClientId,
            'commMethod' => $this->commMethod,
            'tags' => $this->tags,
            'confirmedReady' => $this->confirmedReady,
            'isAvailable' => $this->isAvailable,
            'isOnline' => $this->isOnline,
            'printingJobId' => $this->printingJobId,
            'lastPrintedAt' => $this->lastPrintedAt?->format('c'),
            'integrationId' => $this->integrationId,
            'integrationType' => $this->integrationType,
            'continuousPrint' => $this->continuousPrint,
            'fabmaticRemainingJobs' => $this->fabmaticRemainingJobs,
            'createdAt' => $this->createdAt->format('c'),
            'updatedAt' => $this->updatedAt->format('c'),
            'storeId' => $this->storeId
        ];
    }
}