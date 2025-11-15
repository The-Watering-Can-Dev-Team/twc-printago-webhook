<?php

namespace PrintagoWebhook\src;

use DateTime;
use JsonSerializable;

class PrintJob implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $partBuildId,
        public int $quantityIndex,
        public int $quantityTotal,
        public array $filesToPrint,
        public string $thumbnailUri,
        public string $slicerInputHash,
        public bool $isGcodeCached,
        public string $slicedGcodeUri,
        public string $partId,
        public string $partName,
        public ?string $skuId,
        public ?string $skuName,
        public string $label,
        public ?string $orderId,
        public ?string $orderItemId,
        public ?string $linkedPartId,
        public array $parameterOverrides,
        public int $queueOrder,
        public array $profileUris,
        public array $requiredPrinterTags,
        public ?string $overriddenProcessProfileId,
        public string $assignedPrinterId,
        public int $taskId,
        public DateTime $assignmentStartedAt,
        public DateTime $assignmentCompletedAt,
        public DateTime $printingStartedAt,
        public DateTime $printingCompletedAt,
        public ?DateTime $cancelledAt,
        public string $status,
        public ?string $errorMessage,
        public bool $hidden,
        public ?string $logsUri,
        public PrintJobExtensions $extensions,
        public array $materialMapping,
        public ?array $materialAssignments,
        public int $priority,
        public ?array $skuInstance,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public string $storeId
    ) {}

    public static function fromJson(array $json): self
    {
        $materialMapping = [];
        if (isset($json['materialMapping'])) {
            foreach ($json['materialMapping'] as $mapping) {
                $materialMapping[] = MaterialMapping::fromJson($mapping);
            }
        }

        return new self(
            id: $json['id'],
            partBuildId: $json['partBuildId'],
            quantityIndex: $json['quantityIndex'],
            quantityTotal: $json['quantityTotal'],
            filesToPrint: $json['filesToPrint'],
            thumbnailUri: $json['thumbnailUri'],
            slicerInputHash: $json['slicerInputHash'],
            isGcodeCached: $json['isGcodeCached'],
            slicedGcodeUri: $json['slicedGcodeUri'],
            partId: $json['partId'],
            partName: $json['partName'],
            skuId: $json['skuId'] ?? null,
            skuName: $json['skuName'] ?? null,
            label: $json['label'],
            orderId: $json['orderId'] ?? null,
            orderItemId: $json['orderItemId'] ?? null,
            linkedPartId: $json['linkedPartId'] ?? null,
            parameterOverrides: $json['parameterOverrides'] ?? [],
            queueOrder: $json['queueOrder'],
            profileUris: $json['profileUris'],
            requiredPrinterTags: $json['requiredPrinterTags'] ?? [],
            overriddenProcessProfileId: $json['overriddenProcessProfileId'] ?? null,
            assignedPrinterId: $json['assignedPrinterId'],
            taskId: $json['taskId'],
            assignmentStartedAt: new DateTime($json['assignmentStartedAt']),
            assignmentCompletedAt: new DateTime($json['assignmentCompletedAt']),
            printingStartedAt: new DateTime($json['printingStartedAt']),
            printingCompletedAt: new DateTime($json['printingCompletedAt']),
            cancelledAt: isset($json['cancelledAt']) ? new DateTime($json['cancelledAt']) : null,
            status: $json['status'],
            errorMessage: $json['errorMessage'] ?? null,
            hidden: $json['hidden'],
            logsUri: $json['logsUri'] ?? null,
            extensions: PrintJobExtensions::fromJson($json['extensions']),
            materialMapping: $materialMapping,
            materialAssignments: $json['materialAssignments'] ?? null,
            priority: $json['priority'],
            skuInstance: $json['skuInstance'] ?? null,
            createdAt: new DateTime($json['createdAt']),
            updatedAt: new DateTime($json['updatedAt']),
            storeId: $json['storeId']
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'partBuildId' => $this->partBuildId,
            'quantityIndex' => $this->quantityIndex,
            'quantityTotal' => $this->quantityTotal,
            'filesToPrint' => $this->filesToPrint,
            'thumbnailUri' => $this->thumbnailUri,
            'slicerInputHash' => $this->slicerInputHash,
            'isGcodeCached' => $this->isGcodeCached,
            'slicedGcodeUri' => $this->slicedGcodeUri,
            'partId' => $this->partId,
            'partName' => $this->partName,
            'skuId' => $this->skuId,
            'skuName' => $this->skuName,
            'label' => $this->label,
            'orderId' => $this->orderId,
            'orderItemId' => $this->orderItemId,
            'linkedPartId' => $this->linkedPartId,
            'parameterOverrides' => $this->parameterOverrides,
            'queueOrder' => $this->queueOrder,
            'profileUris' => $this->profileUris,
            'requiredPrinterTags' => $this->requiredPrinterTags,
            'overriddenProcessProfileId' => $this->overriddenProcessProfileId,
            'assignedPrinterId' => $this->assignedPrinterId,
            'taskId' => $this->taskId,
            'assignmentStartedAt' => $this->assignmentStartedAt->format('c'),
            'assignmentCompletedAt' => $this->assignmentCompletedAt->format('c'),
            'printingStartedAt' => $this->printingStartedAt->format('c'),
            'printingCompletedAt' => $this->printingCompletedAt->format('c'),
            'cancelledAt' => $this->cancelledAt?->format('c'),
            'status' => $this->status,
            'errorMessage' => $this->errorMessage,
            'hidden' => $this->hidden,
            'logsUri' => $this->logsUri,
            'extensions' => $this->extensions,
            'materialMapping' => $this->materialMapping,
            'materialAssignments' => $this->materialAssignments,
            'priority' => $this->priority,
            'skuInstance' => $this->skuInstance,
            'createdAt' => $this->createdAt->format('c'),
            'updatedAt' => $this->updatedAt->format('c'),
            'storeId' => $this->storeId
        ];
    }
}