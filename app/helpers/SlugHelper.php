<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SlugHelper
{
    public static function generateUniqueSlug($id, $name, $table, $column)
    {
        $slug = Str::slug($name);
        $count = 1;
        $originalSlug = $slug;

        if ($id) {
            if (DB::table($table)->where($column, $slug)->where('id', $id)->exists()) {
                return $slug;
            } else {
                while (DB::table($table)->where($column, $slug)->exists()) {
                    $slug = $originalSlug . '-' . Str::random(5); // Add a random 5-character string
                    $count++;
                }
            }
        } else {
            while (DB::table($table)->where($column, $slug)->exists()) {
                $slug = $originalSlug . '-' . Str::random(5); // Add a random 5-character string
                $count++;
            }
        }

        return $slug;
    }
}