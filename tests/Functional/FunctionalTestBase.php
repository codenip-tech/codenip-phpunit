<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Repository\UserRepository;
use Doctrine\DBAL\Connection;
use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTestBase extends WebTestCase
{
    use RecreateDatabaseTrait;

    private static ?KernelBrowser $client = null;
    protected static ?KernelBrowser $baseClient = null;
    protected static ?KernelBrowser $authenticatedClient = null;

    public function setUp(): void
    {
        parent::setUp();

        if (null === self::$client) {
            self::$client = static::createClient();
        }

        if (null === self::$baseClient) {
            self::$baseClient = clone self::$client;
            self::$baseClient->setServerParameters([
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
            ]);
        }

        if (null === self::$authenticatedClient) {
            self::$authenticatedClient = clone self::$client;

            $user = static::$container->get(UserRepository::class)->byEmailOrFail('peter@api.com');
            $token = static::$container->get(JWTTokenManagerInterface::class)->create($user);

            self::$authenticatedClient->setServerParameters([
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json',
                'HTTP_Authorization' => \sprintf('Bearer %s', $token),
            ]);
        }
    }

    protected static function initDBConnection(): Connection
    {
        if (null === static::$kernel) {
            static ::bootKernel();
        }

        return static::$kernel->getContainer()->get('doctrine')->getConnection();
    }

    protected function getPeterId()
    {
        return self::initDBConnection()->executeQuery('SELECT id FROM user WHERE email = "peter@api.com"')->fetchOne();
    }
}
