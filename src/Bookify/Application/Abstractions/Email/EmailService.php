<?php

namespace Bookify\Application\Abstractions\Email;

interface EmailService
{
    public function sendAsync(string $recipient, string $subject, string $body);

}