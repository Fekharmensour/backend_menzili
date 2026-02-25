<?php

namespace App\Services;

use Twilio\Http\CurlClient;
use Twilio\AuthStrategy\AuthStrategy;
use Twilio\Http\Response;

class CustomTwilioHttpClient extends CurlClient
{
    protected $caPath;

    public function __construct()
    {
        parent::__construct();
        $this->caPath = base_path(env('SSL_CAFILE_PATH', 'storage/app/cacert.pem'));


        if (!$this->caPath) {
            throw new \Exception('SSL Certificate (cacert.pem) not found. Please ensure it\'s at: ' . base_path(env('SSL_CAFILE_PATH', 'storage/app/cacert.pem')));
        }
    }

    /**
     * Make an HTTP request with SSL verification
     */
    public function request(
        string $method,
        string $url,
        array $params = [],
        array $data = [],
        array $headers = [],
        ?string $user = null,
        ?string $password = null,
        ?int $timeout = null,
        ?AuthStrategy $authStrategy = null
    ): Response {
        $curl = curl_init();

        // Build query string from params
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $curlOptions = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout ?? 30,
            CURLOPT_CONNECTTIMEOUT => $timeout ?? 30,
            CURLOPT_CUSTOMREQUEST => $method,
            // SSL verification settings
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO => $this->caPath,
        ];

        // Add headers
        $headerLines = [];
        foreach ($headers as $name => $value) {
            $headerLines[] = "$name: $value";
        }
        if (!empty($headerLines)) {
            $curlOptions[CURLOPT_HTTPHEADER] = $headerLines;
        }

        // Add body/data if present
        if (!empty($data)) {
            $curlOptions[CURLOPT_POSTFIELDS] = http_build_query($data);
        }

        // Add authentication if provided
        if ($user !== null && $password !== null) {
            $curlOptions[CURLOPT_USERPWD] = $user . ':' . $password;
            $curlOptions[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
        }

        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($error) {
            throw new \Twilio\Exceptions\EnvironmentException("Curl error: " . $error);
        }

        return new Response((int)$statusCode, $response);
    }
}