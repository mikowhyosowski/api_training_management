<?php

use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class TrainingOfferControllerTest extends ApiTestCase
{
    public const USER_TOKEN = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOiIxMjM0NTY3ODkwMDAiLCJ1c2VybmFtZSI6IkpvaG4gRG9lIiwicm9sZXMiOlsiVVNFUiJdfQ.7Y3Do00q0EXoXY2c9qRIRfo0CC2gnct1Lhf8BAW6-u4';
    public const ADMIN_TOKEN = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleCI6IjEyMzQ1Njc4OTAwMDAiLCJ1c2VybmFtZSI6ImFkbWluIn0.LCPmlltCKybWMqy1RMSbHBZRe-9riiUVyIDc_4huhAU';

    public function testWhenCreateTrainingOfferAsUserGet403(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/training_offers',
            [
                'headers' => [
                    'Authorization' => self::USER_TOKEN,
                    'Content-Type' => 'application/ld+json',
                ],
                'json' => [
                    'name' => 'Test Training',
                    'instructor' => [
                        'id' => 0,
                        'firstName' => 'Mikowhy',
                        'lastName' => 'Test',
                    ],
                    'trainingDatetime' => '2024-01-01 10:00:00',
                    'price' => 100.0,
                    'createdAt' => '2024-01-01 10:00:00',
                    'updatedAt' => '2024-01-01 10:00:00',
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testWhenTryUpdateTrainingOfferAsUserGet403(): void
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            '/api/training_offers/43',
            [
                'headers' => [
                    'Authorization' => self::USER_TOKEN,
                    'Content-Type' => 'application/ld+json',
                ],
                'json' => [
                    'name' => 'Test Training',
                    'instructor' => [
                        'id' => 0,
                        'firstName' => 'Mikowhy',
                        'lastName' => 'Test',
                    ],
                    'trainingDatetime' => '2024-01-01 10:00:00',
                    'price' => 100.0,
                    'createdAt' => '2024-01-01 10:00:00',
                    'updatedAt' => '2024-01-01 10:00:00',
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}