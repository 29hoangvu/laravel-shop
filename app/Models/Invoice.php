<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    protected $primaryKey = 'Invoice_id';
    public $timestamps = false; // vì bạn dùng created_at nhưng không dùng updated_at

    protected $fillable = [
        'User_id', 'payment_status', 'order_status', 'Total', 'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_id');
    }

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, 'Invoice_id', 'Invoice_id');
    }
}
