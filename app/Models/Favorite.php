<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'User_id',
        'Product_id',
    ];

    /**
     * The primary key is composite.
     * Override the hasCompositeKey trait or implement a unique identifier if needed.
     */
    protected $primaryKey = null;
    public $incrementing = false;

    /**
     * Get the user that favorited the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'User_id', 'id');
    }

    /**
     * Get the product that was favorited.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_id', 'Product_id');
    }
}