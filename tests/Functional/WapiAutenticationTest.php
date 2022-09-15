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
     * return \Symfony\Bundle\FrameworkBundle\Client
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
            ])
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    public function testAccessSecuredWebApiEndopintWithToken()
    {
        $client = $this->createAuthenticatedClient('admin@example.com', 'admin');
        $client->request('GET', '/wapi/placeholder');

        self::assertResponseIsSuccessful();
    }

    public function testRefreshToken()
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

        $data = json_decode($client->getResponse()->getContent(), true);

        //$client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));


        $client->request(
            'POST',
            '/wapi/token/refresh',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'refresh_token' => $data['refresh_token'],

            ]),

        );

        self::assertResponseIsSuccessful();
    }
}
