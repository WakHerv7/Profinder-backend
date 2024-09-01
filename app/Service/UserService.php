<?php
namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function search_user($words)
    { 
        $users = User::with('roles')
        ->where('nom', 'like', '%' . $words . '%')
        ->get();
        if ($users->isEmpty()) {
            $table = [
                'success' => false,
                'message' => 'Aucun user ne correspond à votre recherche'
            ];
            return $table;
        }
         return $users;
    }
}