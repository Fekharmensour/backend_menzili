<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Exceptions\ConfigurationException;

class TwilioWhatsAppService
{
    protected Client $twilio;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');

        if (!$sid || !$token) {
            throw new ConfigurationException(
                'Twilio credentials must be configured. ' .
                'Set TWILIO_ACCOUNT_SID and TWILIO_AUTH_TOKEN in your .env file.'
            );
        }

        // Use standard Twilio Client (remove custom HTTP client for now)
        $this->twilio = new Client($sid, $token);
    }

    public function sendOtp(string $phone, string $otp): string
    {
        $message = $this->twilio->messages->create(
            "whatsapp:$phone",
            [
                'from' => config('services.twilio.whatsapp_from'),
                'body' => " Your verification code is: *{$otp}*\nThis code expires in 5 minutes."
            ]
        );

        return $message->sid;
    }
}