<?php

namespace App\domain\ValueObjects\LinkForShare;


interface LinkForShare
{
    public function getUrl(): string;
}