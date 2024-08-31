<?php

namespace App\Helper;

use App\Enums\Files\FileTypes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


function removeNullValues($array) {
    
    return array_filter($array->toArray(), function ($value) {
        return $value !== null;
    });
}

function gen_password()
{
    return Hash::make(Str::random(10));
}

    function generateCollectionMeta($collection)
    {
        return [
            
                'total' => $collection->total(),
                'from' => $collection->firstItem(),
                'last_page' => $collection->lastPage(),
                'to' => $collection->lastItem(),
                'per_page' => $collection->perPage(),
                'current_page' => $collection->currentPage(),
               
        
        ];
    }

    
    function paginatedResults($collection)
    {
        $perPage=10;
      // استخدام LengthAwarePaginator لتقسيم النتائج إلى صفحات
$paginatedResults = new LengthAwarePaginator(
    $collection->forPage(request('page'), $perPage),
    $collection->count(),
    $perPage,
    request('page'),
    ['path' => request()->url()]
);
return $paginatedResults;
}

 function getFileType($file)
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


