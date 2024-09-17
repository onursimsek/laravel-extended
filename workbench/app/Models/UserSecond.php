<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Workbench\Database\Factories\UserSecondFactory;

class UserSecond extends Model
{
    use HasFactory;

    protected $connection = 'testing_second_db';

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function newFactory(): UserSecondFactory
    {
        return UserSecondFactory::new();
    }
}
