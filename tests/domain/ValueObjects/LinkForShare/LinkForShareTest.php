<?php

use App\domain\ValueObjects\LinkForShare\LinkForShareFactoryImp;
use PHPUnit\Framework\TestCase;

class LinkForShareTest extends TestCase
{

    public function testLinkForShareMustReturnUrl()
    {
        // Arrange
        $protocol = 'https';
        $domain = 'amazingdomain.com';
        $identifier = '1234';
        $linkForShareFactory = new LinkForShareFactoryImp();
        $linkForShare = $linkForShareFactory->create($protocol, $domain, $identifier);

        // Act
        $url = $linkForShare->getUrl();

        // Assert
        $this->assertEquals('https://amazingdomain.com/secret/1234', $url);
    }

}