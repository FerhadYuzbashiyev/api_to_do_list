<?php

namespace App\DTO;

class CreateTaskData
{
    public function __construct(
        public string $title,
        public string $description,
    ) 
    {}

    public static function fromRequest($request): self
    {
        return new self(
            title: $request->string('title'),
            description: $request->string('description'),
        );
    }
}