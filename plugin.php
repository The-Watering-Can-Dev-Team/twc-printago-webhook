<?php
/*
Plugin Name: The Watering Can - Printago Webhook
Description: Send text message updates from printago
Version: 0.0.1
Author: Josh Wood
Author URI: https://github.com/joshtwc
 */

use PrintagoWebhook\src\ApiResponseParser;
use Twilio\Exceptions\TwilioException;

if (!defined('ABSPATH')) exit;

$files = scandir(__DIR__ . "/src");
foreach ($files as $file) {
    if ($file === "." || $file === "..") {
        continue;
    }
    if (str_ends_with($file, ".php")) {
        require_once __DIR__ . "/src/" . $file;
    }
}

function printago_webhook(WP_REST_Request $request): void
{
    $apiEvent = ApiResponseParser::parse($request->get_body());

    if ($apiEvent->event === 'onPrinterHmsWarning') {
        return;
    }

    if (!class_exists('ComposerAutoloaderInitd4fb758ce07a1e1b7b60b809e775e8c0')) {
        require_once __DIR__ . '/vendor/autoload.php';
    }

    $from   = PRINTAGO_WEBHOOK_FROM;
    $to     = PRINTAGO_WEBHOOK_RECIPIENTS;

    try {
        $twilio = new Twilio\Rest\Client(
            PRINTAGO_TWILIO_ACCOUNT_SID,
            PRINTAGO_TWILIO_AUTH_TOKEN,
        );
    }
    catch (TwilioException $e) {
        error_log($e->getMessage());
        return;
    }

    $message = "";

    switch ($apiEvent->event) {
        case "onJobCompleted":
            $message .= "Job Completed\n";
            break;
        case "onJobFailed":
            $message .= "Job Failed\n";
            break;
    }
    $message .= "Printer: {$apiEvent->data->printer->name}\n";
    $message .= "Printer Status: " . ($apiEvent->data->printer->isOnline ? "Online" : "Offline") . "\n\n";
    if ($apiEvent->data->printJob !== null) {
        $message .= "Status: {$apiEvent->data->printJob->status}\n";
        $message .= "Job: {$apiEvent->data->printJob->label}\n";
        $message .= "Part: {$apiEvent->data->printJob->partName}\n";
        if ($apiEvent->data->printJob->errorMessage) {
            $message .= "Error: " . $apiEvent->data->printJob->errorMessage . "\n";
        }
    }

    foreach ($to as $recipient) {
        try {
            $twilio->messages->create($recipient,
                [
                    'from' => $from,
                    'body' => $message,
                    'mediaUrl' => $apiEvent->data->printJob->thumbnailUri ? [
                        $apiEvent->data->printJob->thumbnailUri
                    ] : []
                ]);
        } catch (\Twilio\Exceptions\TwilioException $e) {
            error_log($e->getMessage());
        }
    }

}

add_action('rest_api_init', function () {
    register_rest_route('printago/v1', 'webhook', [
        'methods' => 'POST',
        'callback' => 'printago_webhook',
        'permission_callback' => function (WP_REST_Request $request) {

            $cfg_file = __DIR__ . '/config.php';
            if (!file_exists($cfg_file)) {
                error_log("Config file not found at " . $cfg_file);
                return new WP_Error('printago_webhook', 'Config file not found', ['status' => 500]);
            }
            require_once $cfg_file;

            $content_type = $request->get_header('Content-Type');
            if ($content_type != 'application/json') {
                return new WP_Error('invalid_content_type', 'Content type must be application/json', ['status' => 400]);
            }
            $api_key = $request->get_header('X-API-Key');
            if (!$api_key) {
                return new WP_Error('missing_api_key', 'Api key is required', ['status' => 401]);
            }
            if ($api_key !== PRINTAGO_WEBHOOK_API_KEY) {
                return new WP_Error('invalid_api_key', 'Api key is not valid', ['status' => 401]);
            }

            return true;
        }
    ]);
});