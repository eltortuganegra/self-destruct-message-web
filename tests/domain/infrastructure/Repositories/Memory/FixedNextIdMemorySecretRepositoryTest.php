<?php


use app\domain\Infrastructure\Repositories\Memory\FixedNextIdMemorySecretRepository;
use App\domain\ValueObjects\ValueObjectsFactory;
use PHPUnit\Framework\TestCase;

class FixedNextIdMemorySecretRepositoryTest extends TestCase
{
    public function testShouldAddSecretToRepository()
    {
        // Arrange
        $secretIdFactory = ValueObjectsFactory::getSecretIdFactory();
        $secretRepository = new FixedNextIdMemorySecretRepository($secretIdFactory);
        $secretId = $secretRepository->nextIdentity();

        // Act
        $identifier = $secretId->getIdentifier();

        // Assert
        $this->assertEquals('42aa8aef-6af5-4b59-9a21-a492d581676a', $identifier);
    }

}