<?php

namespace App\domain\Services;


interface Service
{
    public function execute(ServiceRequest $serviceRequest): ServiceResponse;
}