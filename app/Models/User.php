<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
     protected $table = 'users';
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'User_id'; // tên cột khóa chính trong bảng

    public $incrementing = true; // hoặc false nếu khóa không tự tăng

    protected $keyType = 'int'; // kiểu dữ liệu của khóa chính
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'Email', 'Password', 'Address', 'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get all favorites for the user.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'User_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'User_id', 'user_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'User_id', 'user_id');
    }


}