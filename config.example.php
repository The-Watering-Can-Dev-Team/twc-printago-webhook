<?php

if (!defined('ABSPATH')) exit;

const PRINTAGO_TWILIO_ACCOUNT_SID = "";
const PRINTAGO_TWILIO_AUTH_TOKEN = "";
const PRINTAGO_WEBHOOK_API_KEY = "";
const PRINTAGO_WEBHOOK_FROM = "+11234567890";
const PRINTAGO_WEBHOOK_RECIPIENTS = [
    '+11234567890'
];
// Set to null to allow notifications at all times.
// Or set to a 24h time range ["HH:MM", "HH:MM"] in site timezone (Settings → General → Timezone).
// Examples:
// const PRINTAGO_NOTIFY_WINDOW = ["09:00", "21:00"]; // 9 AM to 9 PM
// const PRINTAGO_NOTIFY_WINDOW = ["22:00", "06:00"]; // 10 PM through 6 AM (overnight window)
const PRINTAGO_NOTIFY_WINDOW = null;

// Optional: Override timezone used for time-based features (like PRINTAGO_NOTIFY_WINDOW).
// Provide an IANA timezone string (e.g., "America/Toronto", "America/Chicago", "UTC").
// If null, the WordPress Site Timezone (Settings → General → Timezone) will be used.
// Example:
// const PRINTAGO_TIMEZONE = "America/Toronto";
const PRINTAGO_TIMEZONE = null;