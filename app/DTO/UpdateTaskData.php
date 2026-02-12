<?php

namespace App\DTO;

use App\Http\Requests\Task\UpdateTaskRequest;

class UpdateTaskData
{
    public function __construct(
        public ?string $title,
        public ?string $description,
    ) 
    {}

    public static function fromArray(UpdateTaskRequest $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
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