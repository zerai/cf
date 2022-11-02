<?php declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiAutenticationTest extends WebTestCase
{
    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\KernelBrowser
     */
    protected function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'username' => $username,
                'password' => $password,
            ], JSON_THROW_ON_ERROR)
        );

        $data = json_decode((string) $client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    /**
     * @test
     */
    public function denyAccessToSecuredApiEndopint(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/placeholder');

        self::assertResponseStatusCodeSame(401);
    }

    /**
     * @test
     */
    public function accessSecuredApiEndopintWithToken(): void
    {
        $client = $this->createAuthenticatedClient('admin@example.com', 'admin');
        $client->request('GET', '/api/placeholder');

        self::assertResponseIsSuccessful();
    }

    /**
     * @test
     */
    public function refreshToken(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'username' => 'admin@example.com',
                'password' => 'admin',
            ])
        );

        $data = json_decode((string) $client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $refreshToken = $data['refresh_token'];

        $client->request(
            'POST',
            '/api/token/refresh',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'refresh_token' => $refreshToken,

            ], JSON_THROW_ON_ERROR),
        );

        $responseData = json_decode((string) $client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();

        self::assertArrayHasKey('token', $responseData);
        self::assertArrayHasKey('refresh_token', $responseData);
    }
}
