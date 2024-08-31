<?php

namespace App\Utils;

use App\Enums\Files\FileTypes;


class Helper
{


    public static function getFileType($file)
    {
        $mimeType = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();
        
        if (strpos($mimeType, 'image') !== false || in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            return FileTypes::IMAGE;
        } elseif (strpos($mimeType, 'video') !== false || in_array($extension, ['mp4', 'mov', 'avi'])) {
            return FileTypes::VIDEO;
        } else {
            return FileTypes::FILE;
        }
    }






  

}
