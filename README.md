# The Watering Can – Printago Webhook (WordPress Plugin)

A lightweight WordPress plugin that exposes a REST API endpoint to receive Printago webhook events and send SMS/MMS notifications via Twilio.

This plugin is intended to be installed in a WordPress site (as a standard plugin) and configured with Twilio credentials and an internal API key to authorize incoming webhook calls.

## Stack and Architecture
- Language: PHP (WordPress plugin)
- Platform: WordPress (uses the REST API)
- Dependency Manager: Composer
- External SDKs/Libraries: `twilio/sdk` (via Composer)
- Entry Point: `plugin.php`
  - Registers REST route: `POST /wp-json/printago/v1/webhook`
  - Callback: `printago_webhook(WP_REST_Request $request)`
  - Loads plugin PHP files from `src/`
  - Loads Composer autoloader from `vendor/autoload.php` when available

## What It Does
- Accepts JSON POST requests from Printago at the route `printago/v1/webhook`.
- Validates content type and an API key header.
- Parses event payload and, for supported events, composes a status message.
- Sends SMS/MMS to one or more recipients using Twilio.
- Ignores `onPrinterHmsWarning` events (no message is sent for that event type).

## Requirements
- PHP compatible with your WordPress installation (match your site’s PHP version).
- WordPress with REST API enabled (default for modern WP versions).
- Composer (to install PHP dependencies) on the machine where you deploy the plugin or a built vendor directory.
- Twilio Account with:
  - Account SID
  - Auth Token
  - A Twilio phone number capable of SMS/MMS (for `PRINTAGO_WEBHOOK_FROM`).

## Installation
1. Place this directory `twc-printago-webhook/` under your WordPress plugins folder:
   `wp-content/plugins/twc-printago-webhook`.
2. Install PHP dependencies (one-time or on update):
   - From the plugin directory, run:
     - `composer install`
3. Create configuration file:
   - Copy `config.example.php` to `config.php` in the plugin root.
   - Fill in the constants with your real values (see Configuration below).
4. Activate the plugin in WordPress Admin → Plugins.

## Configuration
Configuration is done via PHP constants in `config.php` (not committed). Example template is provided in `config.example.php`.

Required constants:
- `PRINTAGO_TWILIO_ACCOUNT_SID` – Your Twilio Account SID.
- `PRINTAGO_TWILIO_AUTH_TOKEN` – Your Twilio Auth Token.
- `PRINTAGO_WEBHOOK_API_KEY` – Shared secret required in the `X-API-Key` request header.
- `PRINTAGO_WEBHOOK_FROM` – Twilio phone number to send from (E.164 format, e.g., `+11234567890`).
- `PRINTAGO_WEBHOOK_RECIPIENTS` – Array of recipient numbers (E.164), e.g.:
  ```php
  const PRINTAGO_WEBHOOK_RECIPIENTS = [
      '+11234567890',
      '+10987654321',
  ];
  ```

Notes:
- The plugin requires `Content-Type: application/json` and the `X-API-Key` header to match `PRINTAGO_WEBHOOK_API_KEY`.
- Composer autoloading: If `vendor/autoload.php` is present, it will be loaded so the `twilio/sdk` classes are available.

## Usage
- Endpoint: `POST /wp-json/printago/v1/webhook`
- Headers:
  - `Content-Type: application/json`
  - `X-API-Key: <your PRINTAGO_WEBHOOK_API_KEY>`
- Body: JSON payload from Printago.

Supported/handled events (as of current code):
- `onJobCompleted` → sends an SMS/MMS prefixed with "Job Completed".
- `onJobFailed` → sends an SMS/MMS prefixed with "Job Failed".
- `onPrinterHmsWarning` → ignored by the plugin (no message sent).

Message composition (based on payload fields):
- Printer name and online status
- Print job status, label, part name
- Error message (if present)
- Thumbnail image URL as MMS media (if `data.printJob.thumbnailUri` is present)

### Example cURL
Replace placeholders with your actual site URL and API key.

```bash
curl -X POST "https://your-site.example.com/wp-json/printago/v1/webhook" \
  -H "Content-Type: application/json" \
  -H "X-API-Key: YOUR_API_KEY" \
  -d '{
    "event": "onJobCompleted",
    "data": {
      "printer": { "name": "Printer A", "isOnline": true },
      "printJob": {
        "status": "COMPLETED",
        "label": "Order #123",
        "partName": "Widget",
        "errorMessage": null,
        "thumbnailUri": "https://example.com/path/to/thumb.jpg"
      }
    }
  }'
```

## Scripts and Commands
From the plugin directory (`wp-content/plugins/twc-printago-webhook`):
- Install dependencies: `composer install`
- Update dependencies: `composer update` (use with caution)

There are no custom Composer scripts defined in `composer.json` at this time.

## Environment Variables
- This plugin currently uses PHP constants in `config.php` rather than environment variables.
- TODO: Document any environment-based configuration if introduced in the future (e.g., pulling from `wp-config.php` or server env).

## Testing
- Automated tests are not included in this repository.
- Manual testing suggestions:
  - Send requests using cURL or Postman to the endpoint with the required headers.
  - Verify WordPress debug logs (`error_log`) for any Twilio exceptions or validation errors.
  - Confirm SMS/MMS delivery to recipients.

TODOs:
- Add unit/integration tests for request validation, event parsing, and Twilio messaging.
- Document full Printago payload schema supported by `ApiResponseParser` in `src/`.

## Project Structure
- `plugin.php` – Main plugin file; registers REST route and handles webhook.
- `src/` – Supporting PHP classes (e.g., `ApiResponseParser`, models for payload fields).
- `config.example.php` – Template for required configuration constants.
- `config.php` – Your local configuration (not committed; required at runtime).
- `composer.json` – Composer dependencies (`twilio/sdk`).
- `composer.lock` – Locked dependency versions (if present).
- `vendor/` – Installed Composer packages (generated by Composer; not usually committed depending on your workflow).

## Deployment Notes
- Ensure `vendor/` is available on the production environment (either commit it or run `composer install` during deployment).
- Keep `config.php` out of version control and secure. The plugin logs Twilio exceptions with `error_log`—ensure logs don’t expose secrets.

## License
- TODO: Add license information for this plugin. If you intend the code to be open source, include a LICENSE file and update this section accordingly.

## Credits
- Author: Josh Wood (https://github.com/joshtwc)
- Twilio PHP SDK: https://github.com/twilio/twilio-php

---
If you have questions or need enhancements (additional event types, different notification channels), please open an issue or contribute improvements.