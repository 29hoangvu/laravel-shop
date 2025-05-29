<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'Product_id';

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
        'Staff_id',
        'Category_id',
        'name',
        'description',
        'price',
        'stock_quantity',
        'image_url',
        'Status',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'Category_id', 'Category_id');
    }

    /**
     * Get the staff that added the product.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'Staff_id', 'Staff_id');
    }

    /**
     * Get all comments for the product.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id', 'Product_id');
    }

    /**
     * Get users who favorited this product.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'Product_id', 'Product_id');
    }

    /**
     * Get invoice details containing this product.
     */
    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'Product_id', 'Product_id');
    }

}