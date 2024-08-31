<?php

namespace App\Traits;

trait Enumable
{
    public static function types()
    {
        return array_map(
            function ($status) {
                return $status->data();
            },
            static::cases()
        );
    }
}
