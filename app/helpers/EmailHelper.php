<?php
namespace App\Helpers;
// Helper file: EmailHelper.php


function isEmailUnique($email, $userId = null)
{
    $isUnique = true;

    // Check if email exists in the `users` table (excluding the current user if provided)
    $query = DB::table('users')->where('email', $email);
    if ($userId !== null) {
        $query->where('id', '<>', $userId);
    }
    if ($query->exists()) {
        $isUnique = false;
    }

    $query = DB::table('customers')->where('email', $email);
    if ($userId !== null) {
        $query->where('id', '<>', $userId);
    }
    if ($query->exists()) {
        $isUnique = false;
    }


    $query = DB::table('vendors')->where('email', $email);
    if ($userId !== null) {
        $query->where('id', '<>', $userId);
    }
    if ($query->exists()) {
        $isUnique = false;
    }

    return $isUnique;
}