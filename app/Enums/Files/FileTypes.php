<?php

namespace App\Enums\Files;
use App\Traits\Enumable;

enum FileTypes: string
{
    use Enumable;
    case IMAGE = 'image';
    case VIDEO = 'video';
    case FILE = 'file';
    public static function toArray(): array
    {
        return array_map(function ($status) {
            return $status->value;
        }, FileTypes::cases());
    }
}
