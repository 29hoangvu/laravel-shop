<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorite'; // ✅ Tên bảng chính xác
    public $timestamps = true;

    protected $primaryKey = null; // ✅ Nếu không có cột ID
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'category_id',
        'score'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id'); // ✅ Sửa lại cho đúng khóa chính
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
