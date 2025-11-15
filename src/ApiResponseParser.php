<?php

namespace PrintagoWebhook\src;

class ApiResponseParser
{
    /**
     * Parse JSON string to ApiEvent object
     *
     * @param string $jsonString
     * @return ApiEvent
     * @throws \InvalidArgumentException
     */
    public static function parse(string $jsonString): ApiEvent
    {
        $data = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON: ' . json_last_error_msg());
        }

        return ApiEvent::fromJson($data);
    }

    /**
     * Parse and handle different event types
     *
     * @param string $jsonString
     * @return ApiEvent
     */
    public static function parseAndHandle(string $jsonString): ApiEvent
    {
        $event = self::parse($jsonString);

        // You can add event-specific handling here
        switch ($event->event) {
            case 'onPrinterHmsWarning':
                // Handle printer warning
                break;
            case 'onJobFailed':
                // Handle job failure
                break;
            case 'onJobCompleted':
                // Handle job completion
                break;
        }

        return $event;
    }
}