<?php

namespace Bookify\Application\Abstractions\Email;

use Bookify\Domain\Users\Email;

interface EmailService
{
    public function sendAsync(Email $recipient, string $subject, string $body);

}