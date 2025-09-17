<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioLookupService
{
    public function __construct(private Client $client) {}

    public function lookup(string $number): array
    {
        try {
            $opts = ['type' => ['carrier']];
            $res = $this->client->lookups->v1->phoneNumbers($number)->fetch($opts);

            return [
                'valid'        => true,
                'e164'         => $res->phoneNumber ?? null,
                'country_code' => $res->countryCode ?? null,
                'carrier'      => $res->carrier['name'] ?? null,
                'type'         => $res->carrier['type'] ?? null,
                'error'        => null,
            ];
        } catch (\Throwable $e) {
            return [
                'valid' => false,
                'e164' => null,
                'country_code' => null,
                'carrier' => null,
                'type' => null,
                'error' => $e->getMessage(),
            ];
        }
    }
}
