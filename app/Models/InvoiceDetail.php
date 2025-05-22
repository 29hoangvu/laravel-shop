<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Invoice_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * The primary key is composite.
     * Override the hasCompositeKey trait or implement a unique identifier if needed.
     */
    protected $primaryKey = null;
    public $incrementing = false;

    /**
     * Get the invoice that owns the invoice detail.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'Invoice_id', 'Invoice_id');
    }

    /**
     * Get the product for this invoice detail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'Product_id');
    }
}