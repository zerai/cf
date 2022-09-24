<?php declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WapiAutenticationTest extends WebTestCase
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
            '/wapi/login_check',
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

    public function testDenyAccessToSecuredWebApiEndopint(): void
    {
        $client = static::createClient();
        $client->request('GET', '/wapi/placeholder');

        self::assertResponseStatusCodeSame(401);
    }

    public function testAccessSecuredWebApiEndopintWithToken(): void
    {
        $client = $this->createAuthenticatedClient('admin@example.com', 'admin');
        $client->request('GET', '/wapi/placeholder');

        self::assertResponseIsSuccessful();
    }

    public function testRefreshToken(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/wapi/login_check',
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
            '/wapi/token/refresh',
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
