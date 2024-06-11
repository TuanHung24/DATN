<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticate;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticate
{
    use HasFactory;
    protected $table='admin';
    protected $hidden = [
        'password', 'remember_token',
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
}
