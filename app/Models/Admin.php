<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticate
{
    use HasFactory;
    protected $table='admin';
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $fillable = [
        'name', 'email', 'password', 'token', 
    ];
    public function isEmployee()
    {
        return $this->roles === 2;
    }

    public function isManager()
    {
        return $this->roles === 1;
    }

    public function isAdmin()
    {
        return $this->roles === 3;
    }

    public static function attemptLogin($username, $password, $remember)
    {
        $user = static::whereRaw('BINARY `username` = ?', [$username])->first();
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            return true;
        }

        return false;
    }
}
