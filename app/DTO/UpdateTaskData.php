<?php

namespace App\DTO;

class UpdateTaskData
{
    public function __construct(
        public ?string $title,
        public ?string $description,
    ) 
    {}

    public static function fromRequest($request): self
    {
        return new self(
            title: $request->string('title'),
            description: $request->string('description'),
        );
    }
    
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'description' => $this->description,
        ], fn($v) => $v !== null);
    }
}