<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersMFA extends Model
{
    use HasFactory;

    protected $table = 'tokens_mfa';

    protected $fillable = [
        'code',
        'user_id',
        'fecha_hora_vencimiento',
        'used'
    ];
}
