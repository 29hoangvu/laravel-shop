<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'invoice_detail';
    public $timestamps = false;

    protected $fillable = [
        'Invoice_id', 'Product_id', 'quantity', 'price'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'Invoice_id', 'Invoice_id');
    }

    public function product()
    {
        // Đây phải là tên khóa ngoại trong bảng invoice_detail và khóa chính bảng products
        return $this->belongsTo(Product::class, 'Product_id', 'Product_id');
    }
}

