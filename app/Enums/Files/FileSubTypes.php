<?php

namespace App\Enums\Files;
use App\Traits\Enumable;

enum FileSubTypes: string
{
   
    case PDF = 'pdf';
    case DOCX = 'docx';
    case XLSX = 'xlsx';
    case MP4 = 'mp4';
    case PNG = 'png';
    case JPG = 'jpg';
    case OTHER= 'other';
    case JPEG='jpeg';
    case GIF='gif';
    case MOV='mov';
    case AVI='avi';
    case PPTX='pptx';
    case WEBP='webp';
    

    public static function toArray(): array
    {
        return array_map(function ($status) {
            return $status->value;
        }, FileSubTypes::cases());
    }

}
