<?php

namespace Bookify\Domain\Reviews;

class Comment
{
    private function __construct(
      private readonly string $comment,
    ) {}

    public static function create(string $comment): self
    {
        return new self($comment);
    }

    public function getComment(): string
    {
        return $this->comment;
    }
}