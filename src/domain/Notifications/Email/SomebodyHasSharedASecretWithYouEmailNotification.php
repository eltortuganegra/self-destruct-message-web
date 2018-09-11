<?php

namespace App\domain\Notifications\Email;

use App\domain\ValueObjects\LinkForShare\LinkForShare;

class SomebodyHasSharedASecretWithYouEmailNotification
{
    private $subject;
    private $body;

    public function __construct(LinkForShare $linkForShare)
    {
        $this->setSubject();
        $this->setBody($linkForShare);
    }

    private function setSubject(): void
    {
        $this->subject = 'Somebody has sent a self destruct message for you!';
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    private function setBody(LinkForShare $linkForShare): void
    {
        $url = $linkForShare->getUrl();

        $this->body =<<<EOD
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Somebody has shared a secret!</title>

    <style type="text/css">
    </style>
</head>
<body style="margin:0; padding:0; background-color:#F2F2F2;">  
    <p>Hi anonymous,</p>  
    <p>You can see the message:</p>
    <p><a href="$url">Unveil the message</a></p>
    <p>Remember: you can see this message only one time.</p>
</body>
</html>
EOD;
    
    }

    public function getBody()
    {
        return $this->body;
    }



}